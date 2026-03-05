<?php

namespace Tests\Feature;

use App\Mail\FacturacionMail;
use App\Models\EmailContact;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class InvoicingEmailTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        EmailContact::create([
            'nombre' => 'Test Recipient',
            'email' => 'recipient@test.com',
            'recibe_facturacion' => true,
            'activo' => true,
        ]);
    }

    public function test_invoicing_form_saves_and_sends_email(): void
    {
        Mail::fake();

        $response = $this->post(route('contact.store'), [
            'type' => 'Facturación',
            'razon_social' => 'Constructora ABC S.A. de C.V.',
            'rfc' => 'CABC850101XYZ',
            'email' => 'fiscal@constructora.com',
            'cuenta_pago' => '1234',
            'calle' => 'Av. Universidad',
            'no_exterior' => '100',
            'no_interior' => 'B',
            'colonia' => 'Centro',
            'cp' => '76000',
            'ciudad' => 'Querétaro',
            'estado' => 'Querétaro',
            'municipio' => 'Querétaro',
            'pais' => 'México',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseCount('contacts', 1);
        $this->assertDatabaseHas('contacts', [
            'type' => 'Facturación',
            'name' => 'Constructora ABC S.A. de C.V.',
            'email' => 'fiscal@constructora.com',
        ]);

        Mail::assertQueued(FacturacionMail::class, function (FacturacionMail $mail): bool {
            return $mail->contact->name === 'Constructora ABC S.A. de C.V.'
                && ($mail->contact->metadata['rfc'] ?? '') === 'CABC850101XYZ';
        });
    }

    public function test_invoicing_form_validates_required_fields(): void
    {
        Mail::fake();

        $response = $this->post(route('contact.store'), [
            'type' => 'Facturación',
            // Missing all required fields
        ]);

        $response->assertSessionHasErrors(['razon_social', 'rfc', 'email', 'cuenta_pago', 'calle']);

        Mail::assertNothingQueued();
        $this->assertDatabaseCount('contacts', 0);
    }

    public function test_invoicing_stores_fiscal_data_in_metadata(): void
    {
        Mail::fake();

        $this->post(route('contact.store'), [
            'type' => 'Facturación',
            'razon_social' => 'Mi Empresa SA',
            'rfc' => 'MEXX010101ABC',
            'email' => 'admin@miempresa.com',
            'cuenta_pago' => '5678',
            'calle' => 'Calle Principal',
            'no_exterior' => '42',
            'no_interior' => '',
            'colonia' => 'Industrial',
            'cp' => '76100',
            'ciudad' => 'León',
            'estado' => 'Guanajuato',
            'municipio' => 'León',
            'pais' => 'México',
        ]);

        $contact = \App\Models\Contact::first();
        $metadata = $contact->metadata;

        $this->assertEquals('MEXX010101ABC', $metadata['rfc']);
        $this->assertEquals('5678', $metadata['cuenta_pago']);
        $this->assertEquals('Calle Principal', $metadata['calle']);
        $this->assertEquals('76100', $metadata['cp']);
    }
}
