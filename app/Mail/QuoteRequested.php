<?php

namespace App\Mail;

use App\Models\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class QuoteRequested extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public Contact $contact,
    ) {
    }

    public function envelope(): Envelope
    {
        $subject = "Nueva Cotización - {$this->contact->name}";

        if ($this->contact->company) {
            $subject .= " - {$this->contact->company}";
        }

        return new Envelope(
            subject: $subject,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.quote-requested',
            with: [
                'contact' => $this->contact,
                'items' => $this->contact->metadata['items'] ?? [],
                'city' => $this->contact->metadata['ciudad'] ?? '',
                'address' => $this->contact->metadata['direccion_obra'] ?? '',
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
