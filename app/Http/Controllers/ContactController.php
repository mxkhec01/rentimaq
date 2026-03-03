<?php

namespace App\Http\Controllers;

use App\Mail\ContactoMail;
use App\Mail\FacturacionMail;
use App\Models\Contact;
use App\Services\EmailRecipientService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function __construct(
        private readonly EmailRecipientService $recipientService,
    ) {
    }

    public function index()
    {
        return view('contact');
    }

    public function store(Request $request)
    {
        $type = $request->input('type', $request->input('tipo', 'Contacto'));

        if ($type === 'Facturación') {
            return $this->storeFacturacion($request);
        }

        return $this->storeContacto($request);
    }

    /**
     * Handle Contacto form submission.
     */
    private function storeContacto(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|min:3|max:255',
            'correo' => 'required|email|max:255',
            'empresa' => 'required|string|max:255',
            'asunto' => 'required|string|max:255',
            'mensaje' => 'nullable|string|max:5000',
        ]);

        $contact = new Contact();
        $contact->type = 'Contacto';
        $contact->name = $validated['nombre'];
        $contact->email = $validated['correo'];
        $contact->company = $validated['empresa'];
        $contact->message = $validated['asunto'] . "\n" . ($validated['mensaje'] ?? '');
        $contact->save();

        // Send email to configured recipients
        $recipients = $this->recipientService->getRecipients('contacto');

        if (!empty($recipients)) {
            Mail::to($recipients)->send(new ContactoMail($contact));
        }

        return back()->with('success', 'Mensaje enviado correctamente. Nos pondremos en contacto pronto.');
    }

    /**
     * Handle Facturación form submission.
     */
    private function storeFacturacion(Request $request)
    {
        $validated = $request->validate([
            'razon_social' => 'required|string|min:3|max:255',
            'rfc' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'cuenta_pago' => 'required|string|max:10',
            'calle' => 'required|string|max:255',
            'no_exterior' => 'required|string|max:20',
            'no_interior' => 'nullable|string|max:20',
            'colonia' => 'required|string|max:255',
            'cp' => 'required|string|max:10',
            'ciudad' => 'required|string|max:255',
            'estado' => 'required|string|max:255',
            'municipio' => 'nullable|string|max:255',
            'pais' => 'nullable|string|max:255',
        ]);

        $contact = new Contact();
        $contact->type = 'Facturación';
        $contact->name = $validated['razon_social'];
        $contact->email = $validated['email'];
        $contact->metadata = collect($validated)
            ->except(['razon_social', 'email'])
            ->toArray();
        $contact->save();

        // Send email to configured recipients
        $recipients = $this->recipientService->getRecipients('facturacion');

        if (!empty($recipients)) {
            Mail::to($recipients)->send(new FacturacionMail($contact));
        }

        return back()->with('success', 'Solicitud de facturación enviada correctamente.');
    }
}
