<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;

class SalesList extends Component
{
    public $search = '';
    public $activeProductId;

    public function setActive($productId)
    {
        $this->activeProductId = $productId;
    }

    public function render()
    {
        $products = Product::where('is_for_sale', true)
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('category', 'like', '%' . $this->search . '%')
                        ->orWhere('description', 'like', '%' . $this->search . '%');
                });
            })
            ->get();

        return view('livewire.sales-list', [
            'products' => $products
        ]);
    }
}
