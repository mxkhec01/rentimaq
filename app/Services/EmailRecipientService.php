<?php

namespace App\Services;

use App\Models\EmailContact;

class EmailRecipientService
{
    /**
     * Get active email recipients for a given form type.
     *
     * @param string $type One of: 'facturacion', 'cotizacion', 'contacto'
     * @return array<string> Array of email addresses
     */
    public function getRecipients(string $type): array
    {
        $recipients = EmailContact::active()
            ->forType($type)
            ->pluck('email')
            ->toArray();

        // Fallback: if table is empty or no recipients found, use config
        if (empty($recipients)) {
            $fallback = config('rentimaq.quote_recipients', '');

            return array_filter(array_map('trim', explode(',', $fallback)));
        }

        return $recipients;
    }
}
