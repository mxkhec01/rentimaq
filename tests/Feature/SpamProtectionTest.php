<?php

namespace Tests\Feature;

use App\Http\Middleware\SpamProtection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class SpamProtectionTest extends TestCase
{
    use RefreshDatabase;

    public function test_honeypot_blocks_submission(): void
    {
        Mail::fake();

        // Bots fill the primary honeypot field
        $response = $this->post(route('contact.store'), [
            'type' => 'Contacto',
            'nombre' => 'Spam Bot',
            'correo' => 'bot@spam.com',
            'empresa' => 'Buy Pills Inc',
            'asunto' => 'Consulta',
            'mensaje' => 'Mensaje normal',
            SpamProtection::HONEYPOT_FIELD => 'http://spam-site.com',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');
        $this->assertDatabaseCount('contacts', 0);
        Mail::assertNothingQueued();
    }

    public function test_secondary_honeypot_blocks_submission(): void
    {
        Mail::fake();

        // Bots fill the secondary honeypot field
        $response = $this->post(route('contact.store'), [
            'type' => 'Contacto',
            'nombre' => 'Spam Bot 2',
            'correo' => 'bot2@spam.com',
            'empresa' => 'Bot Corp',
            'asunto' => 'Consulta',
            'mensaje' => 'Mensaje normal',
            SpamProtection::HONEYPOT_FIELD => '',
            SpamProtection::SECONDARY_HONEYPOT_FIELD => '555-1234',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');
        $this->assertDatabaseCount('contacts', 0);
        Mail::assertNothingQueued();
    }

    public function test_legitimate_submission_passes(): void
    {
        Mail::fake();

        // Human submission: honeypots empty, valid signed timestamp token 10s old
        $humanToken = SpamProtection::generateToken();
        // Decode and backdate it 10 seconds
        $decoded = base64_decode($humanToken);
        $parts = explode('|', $decoded);
        $backdatedTime = time() - 10;
        $salt = $parts[1];
        $key = config('app.key') ?: 'rentimaq-anti-spam-secret';
        $sig = substr(hash_hmac('sha256', $backdatedTime . '|' . $salt, $key), 0, 16);
        $validToken = base64_encode($backdatedTime . '|' . $salt . '|' . $sig);

        $response = $this->post(route('contact.store'), [
            'type' => 'Contacto',
            'nombre' => 'Juan Real',
            'correo' => 'juan@real.com',
            'empresa' => 'Constructora Legítima',
            'asunto' => 'Solicitud real',
            'mensaje' => 'Quiero rentar una revolvedora.',
            SpamProtection::HONEYPOT_FIELD => '',
            SpamProtection::SECONDARY_HONEYPOT_FIELD => '',
            SpamProtection::TIMESTAMP_FIELD => $validToken,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseCount('contacts', 1);
    }

    public function test_too_fast_submission_is_blocked(): void
    {
        Mail::fake();

        // Instant token (< 3 seconds)
        $instantToken = SpamProtection::generateToken();

        $response = $this->post(route('contact.store'), [
            'type' => 'Contacto',
            'nombre' => 'Fast Bot',
            'correo' => 'fast@bot.com',
            'empresa' => 'Speed Corp',
            'asunto' => 'Instant submission',
            'mensaje' => 'Too fast for humans',
            SpamProtection::HONEYPOT_FIELD => '',
            SpamProtection::TIMESTAMP_FIELD => $instantToken,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');
        $this->assertDatabaseCount('contacts', 0);
        Mail::assertNothingQueued();
    }

    public function test_url_links_in_message_are_blocked(): void
    {
        Mail::fake();

        $humanToken = base64_encode((time() - 10) . '|' . mt_rand(1000, 9999));

        // Attempting to post URLs like the Lamborghini telegra.ph scam
        $response = $this->post(route('contact.store'), [
            'type' => 'Contacto',
            'nombre' => 'LarryLor',
            'correo' => 'kaksxd1001@gmail.com',
            'empresa' => 'LarryLor',
            'asunto' => '434971',
            'mensaje' => 'Be the major prizewinner of the Lamborghini Aventador https://telegra.ph/Win-a-new-Lamborghini-Aventador-today',
            SpamProtection::HONEYPOT_FIELD => '',
            SpamProtection::TIMESTAMP_FIELD => $humanToken,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');
        $this->assertDatabaseCount('contacts', 0);
        Mail::assertNothingQueued();
    }

    public function test_foreign_script_is_blocked(): void
    {
        Mail::fake();

        $humanToken = base64_encode((time() - 10) . '|' . mt_rand(1000, 9999));

        $response = $this->post(route('contact.store'), [
            'type' => 'Contacto',
            'nombre' => 'Иван Смирнов',
            'correo' => 'ivan@yandex.ru',
            'empresa' => 'Строительство',
            'asunto' => 'Предложение',
            'mensaje' => 'Купить оборудование со скидкой',
            SpamProtection::HONEYPOT_FIELD => '',
            SpamProtection::TIMESTAMP_FIELD => $humanToken,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');
        $this->assertDatabaseCount('contacts', 0);
        Mail::assertNothingQueued();
    }

    public function test_spam_keywords_are_blocked(): void
    {
        Mail::fake();

        $humanToken = base64_encode((time() - 10) . '|' . mt_rand(1000, 9999));

        $response = $this->post(route('contact.store'), [
            'type' => 'Contacto',
            'nombre' => 'Spammer',
            'correo' => 'crypto@spam.com',
            'empresa' => 'Crypto Trade',
            'asunto' => 'Crypto investment opportunity',
            'mensaje' => 'Earn passive income with our new platform',
            SpamProtection::HONEYPOT_FIELD => '',
            SpamProtection::TIMESTAMP_FIELD => $humanToken,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');
        $this->assertDatabaseCount('contacts', 0);
        Mail::assertNothingQueued();
    }

    public function test_tampered_token_signature_is_blocked(): void
    {
        Mail::fake();

        // 3 parts with invalid signature
        $tamperedToken = base64_encode((time() - 10) . '|9999|invalid_signature');

        $response = $this->post(route('contact.store'), [
            'type' => 'Contacto',
            'nombre' => 'Hacker Bot',
            'correo' => 'hacker@bot.com',
            'empresa' => 'Hack Corp',
            'asunto' => 'Consulta',
            'mensaje' => 'Texto normal',
            SpamProtection::HONEYPOT_FIELD => '',
            SpamProtection::TIMESTAMP_FIELD => $tamperedToken,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');
        $this->assertDatabaseCount('contacts', 0);
        Mail::assertNothingQueued();
    }

    public function test_token_generation_structure(): void
    {
        $token = SpamProtection::generateToken();

        $this->assertNotEmpty($token);

        $decoded = base64_decode($token, true);
        $this->assertNotFalse($decoded);

        $parts = explode('|', $decoded);
        $this->assertCount(3, $parts);
        $this->assertTrue(is_numeric($parts[0]));
        $this->assertTrue(is_numeric($parts[1]));
        $this->assertNotEmpty($parts[2]);
    }
}
