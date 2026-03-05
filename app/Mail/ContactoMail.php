<?php

namespace App\Mail;

use App\Models\Contact;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class ContactoMail extends Mailable
{

    public function __construct(
        public Contact $contact,
    ) {
    }

    public function envelope(): Envelope
    {
        $subject = "Nuevo Contacto — {$this->contact->name}";

        if ($this->contact->company) {
            $subject .= " — {$this->contact->company}";
        }

        return new Envelope(
            subject: $subject,
        );
    }

    public function content(): Content
    {
        // Extract asunto and mensaje from the combined message field
        $parts = explode("\n", $this->contact->message ?? '', 2);
        $asunto = trim($parts[0] ?? '');
        $mensaje = trim($parts[1] ?? '');

        return new Content(
            view: 'emails.contacto',
            with: [
                'contact' => $this->contact,
                'asunto' => $asunto,
                'mensaje' => $mensaje,
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
