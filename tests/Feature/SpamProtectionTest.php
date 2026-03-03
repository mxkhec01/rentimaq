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

        // Bots fill the honeypot field — this should be silently rejected
        $response = $this->post(route('contact.store'), [
            'type' => 'Contacto',
            'nombre' => 'Spam Bot',
            'correo' => 'bot@spam.com',
            'empresa' => 'Buy Pills Inc',
            'asunto' => 'Buy cheap pills',
            'mensaje' => 'Click here for deals',
            SpamProtection::HONEYPOT_FIELD => 'http://spam-site.com', // BOT fills this
        ]);

        // Middleware returns fake "success" to not alert the bot
        $response->assertRedirect();
        $response->assertSessionHas('success');

        // But nothing was actually saved or emailed
        $this->assertDatabaseCount('contacts', 0);
        Mail::assertNothingQueued();
    }

    public function test_legitimate_submission_passes(): void
    {
        Mail::fake();

        // Human submission: honeypot is empty, timestamp is 10 seconds old (human took time)
        $humanToken = base64_encode((time() - 10) . '|' . mt_rand(1000, 9999));

        $response = $this->post(route('contact.store'), [
            'type' => 'Contacto',
            'nombre' => 'Juan Real',
            'correo' => 'juan@real.com',
            'empresa' => 'Constructora Legítima',
            'asunto' => 'Solicitud real',
            'mensaje' => 'Quiero rentar equipo.',
            SpamProtection::HONEYPOT_FIELD => '', // Human leaves it empty
            SpamProtection::TIMESTAMP_FIELD => $humanToken,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseCount('contacts', 1);
    }

    public function test_too_fast_submission_is_blocked(): void
    {
        Mail::fake();

        // Generate a token from "right now" and submit immediately (< 3 seconds)
        // The token encodes the current timestamp, so elapsed = 0 seconds
        $instantToken = base64_encode(time() . '|' . mt_rand(1000, 9999));

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

        // Returns fake success but nothing saved
        $response->assertRedirect();
        $response->assertSessionHas('success');
        $this->assertDatabaseCount('contacts', 0);
        Mail::assertNothingQueued();
    }

    public function test_old_enough_timestamp_passes(): void
    {
        Mail::fake();

        // Simulate a token that was generated 10 seconds ago
        $oldToken = base64_encode((time() - 10) . '|' . mt_rand(1000, 9999));

        $response = $this->post(route('contact.store'), [
            'type' => 'Contacto',
            'nombre' => 'Paciente Humano',
            'correo' => 'paciente@real.com',
            'empresa' => 'Empresa Real',
            'asunto' => 'Consulta legítima',
            'mensaje' => 'Tomé mi tiempo para escribir esto.',
            SpamProtection::HONEYPOT_FIELD => '',
            SpamProtection::TIMESTAMP_FIELD => $oldToken,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseCount('contacts', 1);
    }

    public function test_token_generation_is_valid_base64(): void
    {
        $token = SpamProtection::generateToken();

        $this->assertNotEmpty($token);

        $decoded = base64_decode($token, true);
        $this->assertNotFalse($decoded);

        $parts = explode('|', $decoded);
        $this->assertCount(2, $parts);
        $this->assertTrue(is_numeric($parts[0]));
    }
}
