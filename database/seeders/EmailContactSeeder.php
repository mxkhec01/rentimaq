<?php

namespace Database\Seeders;

use App\Models\EmailContact;
use Illuminate\Database\Seeder;

class EmailContactSeeder extends Seeder
{
    public function run(): void
    {
        $contacts = [
            [
                'nombre' => 'Contacto Rentimaq',
                'email' => 'contacto@rentimaq.com',
                'recibe_facturacion' => true,
                'recibe_cotizacion' => true,
                'recibe_contacto' => true,
                'activo' => true,
            ],
            [
                'nombre' => 'A. Morán',
                'email' => 'amoran@rentimaq.com',
                'recibe_facturacion' => true,
                'recibe_cotizacion' => true,
                'recibe_contacto' => true,
                'activo' => true,
            ],
        ];

        foreach ($contacts as $contact) {
            EmailContact::updateOrCreate(
                ['email' => $contact['email']],
                $contact,
            );
        }
    }
}
