<?php

namespace Tests\Feature;

use App\Mail\ContactoMail;
use App\Models\EmailContact;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ContactEmailTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Seed email_contacts so the service finds recipients
        EmailContact::create([
            'nombre' => 'Test Recipient',
            'email' => 'recipient@test.com',
            'recibe_contacto' => true,
            'activo' => true,
        ]);
    }

    public function test_contact_form_saves_and_sends_email(): void
    {
        Mail::fake();

        $response = $this->post(route('contact.store'), [
            'type' => 'Contacto',
            'nombre' => 'Juan Pérez',
            'correo' => 'juan@example.com',
            'empresa' => 'Constructora XYZ',
            'asunto' => 'Consulta de precios',
            'mensaje' => 'Me interesa rentar equipo.',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseCount('contacts', 1);
        $this->assertDatabaseHas('contacts', [
            'type' => 'Contacto',
            'name' => 'Juan Pérez',
            'email' => 'juan@example.com',
            'company' => 'Constructora XYZ',
        ]);

        Mail::assertSent(ContactoMail::class, function (ContactoMail $mail): bool {
            return $mail->contact->name === 'Juan Pérez'
                && $mail->contact->company === 'Constructora XYZ';
        });
    }

    public function test_contact_form_validates_required_fields(): void
    {
        Mail::fake();

        $response = $this->post(route('contact.store'), [
            'type' => 'Contacto',
            // Missing all required fields
        ]);

        $response->assertSessionHasErrors(['nombre', 'correo', 'empresa', 'asunto']);

        Mail::assertNothingSent();
        $this->assertDatabaseCount('contacts', 0);
    }

    public function test_contact_email_not_sent_when_no_active_recipients(): void
    {
        Mail::fake();

        // Deactivate all recipients
        EmailContact::query()->update(['activo' => false]);

        // Also clear the config fallback
        config(['rentimaq.quote_recipients' => '']);

        $response = $this->post(route('contact.store'), [
            'type' => 'Contacto',
            'nombre' => 'María López',
            'correo' => 'maria@example.com',
            'empresa' => 'Obras ML',
            'asunto' => 'Información general',
            'mensaje' => 'Solicito información.',
        ]);

        $response->assertRedirect();

        // Contact is saved even if no email sent
        $this->assertDatabaseCount('contacts', 1);

        // No email queued because no active recipients
        Mail::assertNothingSent();
    }
}
