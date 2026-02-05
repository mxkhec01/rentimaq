<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QuoteController extends Controller
{
    //
    public function index()
    {
        $products = \App\Models\Product::where('is_rental', true)->with(['rentalPrices.rentalPeriod'])->orderBy('id')->get();
        $periods = \App\Models\RentalPeriod::orderBy('order_column')->get();
        return view('quote', compact('products', 'periods'));
    }

    public function store(\Illuminate\Http\Request $request)
    {
        $contact = new \App\Models\Contact();
        $contact->type = 'Cotización - ' . ucfirst($request->input('tipo'));
        $contact->name = $request->input('nombre');
        $contact->email = $request->input('correo');
        $contact->phone = $request->input('telefono');
        $contact->company = $request->input('empresa');

        $metadata = [
            'ciudad' => $request->input('ciudad'),
            'direccion_obra' => $request->input('direccion-obra'),
        ];

        // Fetch products with consistent ordering to match the View's index
        $products = \App\Models\Product::where('is_rental', true)->orderBy('id')->get()->values();
        $totalProducts = $products->count();

        $items = [];
        // Loop up to the actual product count (or a reasonable safety limit if JS is still loose)
        for ($i = 0; $i < $totalProducts; $i++) {
            if ($request->filled("t$i")) {
                $qty = $request->input("t$i");
                if ($qty > 0) {
                    $product = $products[$i] ?? null;
                    $item = [
                        'product' => $product ? $product->name : "Unknown Product (ID mismatch)",
                        'quantity' => $qty,
                    ];
                    if ($request->has("c$i")) {
                        $item['duration'] = $request->input("c$i") . ' ' . $request->input("op$i");
                    }
                    $items[] = $item;
                }
            }
        }

        $metadata['items'] = $items;
        $contact->metadata = $metadata;

        // Build message for readability
        $msg = "Cotización solicitada:\n";
        foreach ($items as $item) {
            $msg .= "- {$item['product']}: {$item['quantity']}";
            if (isset($item['duration'])) {
                $msg .= " (Tiempo: {$item['duration']})";
            }
            $msg .= "\n";
        }
        $contact->message = $msg;

        $contact->save();

        return back()->with('success', 'Cotización enviada correctamente.');
    }
}
