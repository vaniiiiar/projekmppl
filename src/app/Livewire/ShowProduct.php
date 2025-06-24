<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\PageConfig;
use App\Models\Product;



class ShowProduct extends Component
{
    public function render()
    {
        $config = PageConfig::first();
        $products = Product::where('is_available', true)
                          ->orderBy('id')
                          ->get();

        return view('livewire.show-product', [
            'config' => $config,
            'products' => $products
        ]);
        
    }
}   
