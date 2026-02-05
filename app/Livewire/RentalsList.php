<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;

class RentalsList extends Component
{
    public $search = '';
    public $activeProductId;
    public $periods;

    public function mount()
    {
        $this->periods = \App\Models\RentalPeriod::orderBy('order_column')->get();
        // Set first product as active if exists
        $this->activeProductId = null;
    }

    public function setActive($productId)
    {
        $this->activeProductId = $productId;
    }

    public function addToQuote($productId)
    {
        $product = Product::with('rentalPrices.rentalPeriod')->find($productId);

        if (!$product)
            return;

        $quoteItems = session('quoteItems', []);
        $found = false;

        // Check if already in cart
        foreach ($quoteItems as $index => $item) {
            if ($item['product_id'] == $productId) {
                $quoteItems[$index]['qty']++;
                $found = true;
                break;
            }
        }

        if (!$found) {
            $quoteItems[] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'image' => $product->image,
                'category' => $product->category,
                'qty' => 1,
                'duration' => 1,
                'period' => 'day', // Default period
                'available_periods' => $product->rentalPrices->map(function ($p) {
                    if (!$p->rentalPeriod)
                        return null;
                    return [
                        'id' => $p->rentalPeriod->id,
                        'label' => $p->rentalPeriod->label,
                        'price' => $p->price
                    ];
                })->filter()->values()->toArray()
            ];
        }

        session()->put('quoteItems', $quoteItems);

        // Dispatch event instead of redirecting
        $this->dispatch('product-added-to-quote', message: 'Producto agregado a la cotización');

        // Close modal
        $this->activeProductId = null;
    }

    public function render()
    {
        $products = Product::where('is_rental', true)
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('category', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%');
            })
            ->with('rentalPrices')
            ->get();

        return view('livewire.rentals-list', [
            'products' => $products
        ]);
    }
}
