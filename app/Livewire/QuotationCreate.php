<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\Party;

class QuotationCreate extends Component
{
    public $customers;
    public $products;
    public $selectedCustomer;
    public $selectedProduct;
    public $productQty = 1;
    public $width = 0;
    public $height = 0;

    public $selectedProducts = [];
    public $quantities = [];
    public $totalAmount = 0;

    public function mount()
    {
        $this->customers = \App\Models\Party::where('type', 'customer')->get();
        $this->products = \App\Models\Product::get();
    }

    public function addProduct()
    {
        if ($this->selectedProduct && $this->width > 0 && $this->height > 0) {
            $product = $this->products->find($this->selectedProduct);

            // Calculate square footage
            $squareFeet = $this->width * $this->height;

            // Calculate total price (sqft * price * qty)
            $totalPrice = $squareFeet * $product->price * $this->productQty;

            $this->selectedProducts[] = [
                'id' => $product->id,
                'name' => $product->name,
                'width' => $this->width,
                'height' => $this->height,
                'qty' => $this->productQty,
                'price' => $product->price,
                'total' => $totalPrice,
            ];

            // Store quantities
            $this->quantities[$product->id] = $this->productQty;

            // Reset inputs
            $this->productQty = 1;
            $this->width = 0;
            $this->height = 0;
            $this->selectedProduct = null;

            // Update total amount
            $this->calculateTotal();
        }
    }

    public function removeProduct($productId)
    {
        $this->selectedProducts = array_filter($this->selectedProducts, function ($product) use ($productId) {
            return $product['id'] !== $productId;
        });

        $this->calculateTotal();
    }

    public function updateProduct($productId)
    {
        foreach ($this->selectedProducts as &$product) {
            if ($product['id'] == $productId) {
                $squareFeet = $product['width'] * $product['height'];
                $product['total'] = $squareFeet * $product['price'] * $this->quantities[$productId];
            }
        }

        $this->calculateTotal();
    }

    public function calculateTotal()
    {
        $this->totalAmount = array_sum(array_column($this->selectedProducts, 'total'));
    }

    public function createQuotation()
    {
        $this->calculateTotal();

        $quotation = \App\Models\Quotation::create([
            'customer_id' => $this->selectedCustomer,
            'total_amount' => $this->totalAmount,
        ]);

        foreach ($this->selectedProducts as $product) {
            \App\Models\QuotationProduct::create([
                'quotation_id' => $quotation->id,
                'product_id' => $product['id'],
                'width' => $product['width'],
                'height' => $product['height'],
                'qty' => $product['qty'],
                'price' => $product['price'],
                'total' => $product['total'],
            ]);
        }

        $this->dispatch('success', status: 'Quotation created successfully!');
    }

    public function render()
    {
        return view('livewire.quotation-create');
    }
}