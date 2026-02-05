<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    //
    public function index()
    {
        return view('contact');
    }

    public function store(\Illuminate\Http\Request $request)
    {
        // Validation could be added here

        $data = $request->all();
        $type = $data['type'] ?? $data['tipo'] ?? 'Contacto';

        $contact = new \App\Models\Contact();
        $contact->type = $type;

        if ($type === 'Facturación') {
            $contact->name = $data['razon_social'];
            $contact->email = $data['email'];
            // Phone not in invoicing form?
            // Store address etc in metadata
            $contact->metadata = $request->except(['_token', 'type', 'razon_social', 'email']);
        } else {
            // Standard contact
            $contact->name = $data['nombre'];
            $contact->email = $data['correo'];
            $contact->company = $data['empresa'] ?? null;
            $contact->message = ($data['asunto'] ?? '') . "\n" . ($data['mensaje'] ?? '');

            // Quote form sends phone (telefono), city (ciudad)
            if (isset($data['telefono'])) {
                $contact->phone = $data['telefono'];
            }
            if (isset($data['ciudad'])) {
                $contact->metadata = ['ciudad' => $data['ciudad']];
            }
        }

        $contact->save();

        // TODO: Send email

        return back()->with('success', 'Mensaje enviado correctamente.');
    }
}
