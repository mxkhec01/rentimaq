<?php

namespace App\Mail;

use App\Models\Contact;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class FacturacionMail extends Mailable
{

    public function __construct(
        public Contact $contact,
    ) {
    }

    public function envelope(): Envelope
    {
        $razonSocial = $this->contact->name;

        return new Envelope(
            subject: "Solicitud de Facturación — {$razonSocial}",
        );
    }

    public function content(): Content
    {
        $metadata = $this->contact->metadata ?? [];

        return new Content(
            view: 'emails.facturacion',
            with: [
                'contact' => $this->contact,
                'razonSocial' => $this->contact->name,
                'email' => $this->contact->email,
                'rfc' => $metadata['rfc'] ?? 'N/A',
                'cuentaPago' => $metadata['cuenta_pago'] ?? 'N/A',
                'calle' => $metadata['calle'] ?? 'N/A',
                'noExterior' => $metadata['no_exterior'] ?? 'N/A',
                'noInterior' => $metadata['no_interior'] ?? 'N/A',
                'colonia' => $metadata['colonia'] ?? 'N/A',
                'cp' => $metadata['cp'] ?? 'N/A',
                'ciudad' => $metadata['ciudad'] ?? 'N/A',
                'estado' => $metadata['estado'] ?? 'N/A',
                'municipio' => $metadata['municipio'] ?? 'N/A',
                'pais' => $metadata['pais'] ?? 'México',
            ],
        );
    }

    /**
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
