<?php

namespace App\Livewire;

use App\Models\Product;
use App\Models\Contact;
use Livewire\Component;
use Illuminate\Support\Facades\Mail; // Future use if mailing
use Livewire\WithPagination;

class QuoteBuilder extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    // Search & Filter
    public $search = '';
    public $categoryFilter = '';

    // Cart State
    public $quoteItems = [];

    // Contact Form State
    public $contact = [
        'name' => '',
        'email' => '',
        'phone' => '',
        'company' => '',
        'city' => '',
        'address' => '',
        'message' => '', // Optional extra notes
        'type' => 'renta' // Default to rental
    ];

    // Listeners
    protected $queryString = ['search'];

    public function mount()
    {
        // Initialize from session
        $this->quoteItems = session('quoteItems', []);

        // Sanitize/Upgrade session data for old items
        foreach ($this->quoteItems as &$item) {
            if (!isset($item['allow_rent'])) {
                $item['allow_rent'] = true; // Legacy assumption
                $item['allow_sale'] = false;
                $item['transaction_type'] = 'rent';
            }
        }
    }

    public function addToQuote($productId)
    {
        $product = Product::with('rentalPrices.rentalPeriod')->find($productId);

        if (!$product)
            return;

        // Check if already in cart
        foreach ($this->quoteItems as $index => $item) {
            if ($item['product_id'] == $productId) {
                // Increment qty
                $this->quoteItems[$index]['qty']++;
                $this->syncSession();
                return;
            }
        }

        // Add new item
        $this->quoteItems[] = [
            'product_id' => $product->id,
            'name' => $product->name,
            'image' => $product->image,
            'category' => $product->category,
            'qty' => 1,
            'duration' => 1,
            'period' => 'day', // Default period
            'transaction_type' => $product->is_rental ? 'rent' : 'sale', // Default to rent if available
            'allow_rent' => $product->is_rental,
            'allow_sale' => $product->is_for_sale,
            'available_periods' => $product->rentalPrices->map(function ($p) {
                if (!$p->rentalPeriod)
                    return null; // Safety check
                return [
                    'id' => $p->rentalPeriod->id,
                    'label' => $p->rentalPeriod->label,
                    'price' => $p->price
                ];
            })->filter()->values()->toArray()
        ];

        $this->syncSession();
        // Feedback via toast event
        $this->dispatch('product-added-to-quote-builder', message: 'Producto agregado a la cotización.');
    }

    public function removeFromQuote($index)
    {
        unset($this->quoteItems[$index]);
        $this->quoteItems = array_values($this->quoteItems); // Re-index
        $this->syncSession();
    }

    // Helper to persist state
    private function syncSession()
    {
        session()->put('quoteItems', $this->quoteItems);
    }

    public function updateItemQty($index, $change)
    {
        if (!isset($this->quoteItems[$index]))
            return;

        $newQty = $this->quoteItems[$index]['qty'] + $change;
        if ($newQty < 1)
            $newQty = 1;

        $this->quoteItems[$index]['qty'] = $newQty;
        $this->syncSession();
    }

    public function updateItemDuration($index, $change)
    {
        if (!isset($this->quoteItems[$index]))
            return;

        $newDuration = $this->quoteItems[$index]['duration'] + $change;
        if ($newDuration < 1)
            $newDuration = 1;

        $this->quoteItems[$index]['duration'] = $newDuration;
        $this->syncSession();
    }

    // Explicitly sync explicitly on input updates?
    // Livewire updates properties individually. We can use updated lifecycle hook.
    public function updatedQuoteItems()
    {
        $this->syncSession();
    }

    public function submitQuote()
    {
        $this->validate([
            'quoteItems' => 'required|array|min:1',
            'contact.name' => 'required|min:3',
            'contact.email' => 'required|email',
            'contact.phone' => 'required',
            'contact.company' => 'required',
            'contact.city' => 'required',
        ], [
            'quoteItems.required' => 'Debes agregar al menos un equipo a la cotización.',
            'contact.name.required' => 'El nombre es obligatorio.',
        ]);

        // Create Contact Record
        $contact = new Contact();
        $contact->type = 'Cotización - ' . ucfirst($this->contact['type']);
        $contact->name = $this->contact['name'];
        $contact->email = $this->contact['email'];
        $contact->phone = $this->contact['phone'];
        $contact->company = $this->contact['company'];

        // Build Metadata
        $metadata = [
            'ciudad' => $this->contact['city'],
            'direccion_obra' => $this->contact['address'],
            'items' => array_map(function ($item) {
                $details = $item['transaction_type'] === 'rent'
                    ? "Renta: {$item['duration']} {$item['period']}"
                    : "Compra (Venta)";
                return [
                    'product' => $item['name'],
                    'type' => $item['transaction_type'],
                    'quantity' => $item['qty'],
                    'details' => $details,
                ];
            }, $this->quoteItems)
        ];
        $contact->metadata = $metadata;

        // Message
        $msg = "Nueva Cotización Solicitada:\n\n";
        foreach ($metadata['items'] as $item) {
            $msg .= "- {$item['product']} (Cant: {$item['quantity']}, {$item['details']})\n";
        }
        $msg .= "\nNotas: " . $this->contact['message'];

        $contact->message = $msg;
        $contact->save();

        // Reset and Notify
        $this->reset(['quoteItems', 'contact']);
        session()->forget('quoteItems'); // Clear session
        session()->flash('success', '¡Cotización enviada con éxito! Nos pondremos en contacto pronto.');
    }

    public function render()
    {
        $products = Product::query()
            ->where(function ($q) {
                $q->where('is_rental', true)
                    ->orWhere('is_for_sale', true);
            })
            ->when($this->search, function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('category', 'like', '%' . $this->search . '%');
            })
            ->orderBy('name')
            ->paginate(9); // Grid of 9

        return view('livewire.quote-builder', [
            'products' => $products
        ]);
    }
}
