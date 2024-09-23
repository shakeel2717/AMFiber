<?php

namespace App\Livewire;

use App\Models\Notification;
use Livewire\Component;
use App\Models\Product;
use App\Models\Party;

class InvoiceCreate extends Component
{
    public $customers;
    public $products;
    public $selectedCustomer;
    public $selectedProduct;
    public $productQty = 1;
    public $width_in_feet = 0;
    public $width_in_inches = 0;
    public $height_in_feet = 0;
    public $height_in_inches = 0;

    public $selectedProducts = [];
    public $quantities = [];
    public $totalAmount = 0;

    public $discount = 0;
    public $discounted_amount;
    public $without_discounted_amount;

    public function mount()
    {
        $this->customers = \App\Models\Party::where('type', 'customer')->get();
        $this->products = \App\Models\Product::get();
    }

    public function addProduct()
    {
        if ($this->width_in_feet == '') {
            $this->width_in_feet = 0;
        } elseif ($this->width_in_inches == '') {
            $this->width_in_inches = 0;
        }

        if ($this->height_in_feet == '') {
            $this->height_in_feet = 0;
        } elseif ($this->height_in_inches == '') {
            $this->height_in_inches = 0;
        }

        if (
            $this->selectedProduct
            && ($this->width_in_feet > 0
                || $this->width_in_inches > 0)
            && ($this->height_in_feet > 0
                || $this->height_in_inches > 0)
        ) {
            $product = $this->products->find($this->selectedProduct);

            $totalWidthInFeet = $this->width_in_feet + ($this->width_in_inches / 12);
            $totalHeightInFeet = $this->height_in_feet + ($this->height_in_inches / 12);

            // Calculate square footage
            $squareFeet = $totalWidthInFeet * $totalHeightInFeet;

            // Calculate total price (sqft * price * qty)
            $totalPrice = $squareFeet * $product->price * $this->productQty;

            $this->selectedProducts[] = [
                'id' => $product->id,
                'name' => $product->name,
                'width_in_feet' => $this->width_in_feet,
                'width_in_inches' => $this->width_in_inches,
                'height_in_feet' => $this->height_in_feet,
                'height_in_inches' => $this->height_in_inches,
                'qty' => $this->productQty,
                'price' => $product->price,
                'total' => $totalPrice,
            ];

            // Store quantities
            $this->quantities[$product->id] = $this->productQty;

            // Reset inputs
            $this->productQty = 1;
            $this->width_in_feet = null;
            $this->width_in_inches = null;
            $this->height_in_feet = null;
            $this->height_in_inches = null;
            $this->selectedProduct = null;

            // Update total amount
            $this->calculateTotal();
        } else {
            $this->dispatch('error', status: 'Please select product and enter dimensions');
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
        $total = $this->totalAmount = array_sum(array_column($this->selectedProducts, 'total'));
        $this->without_discounted_amount = $total;
        if ($this->discount > 0) {
            $this->discounted_amount = $total * $this->discount / 100;
            $this->totalAmount = $this->totalAmount - $this->discounted_amount;

        } else {
            $this->totalAmount = array_sum(array_column($this->selectedProducts, 'total'));
        }
    }

    public function createInvoice()
    {
        $this->calculateTotal();

        $invoice = \App\Models\Invoice::create([
            'customer_id' => $this->selectedCustomer,
            'total_amount' => $this->totalAmount,
            'discount' => $this->discount,
        ]);

        foreach ($this->selectedProducts as $product) {
            \App\Models\InvoiceProduct::create([
                'product_id' => $product['id'],
                'invoice_id' => $invoice->id,
                'width_in_feet' => $product['width_in_feet'],
                'width_in_inches' => $product['width_in_inches'],
                'height_in_feet' => $product['height_in_feet'],
                'height_in_inches' => $product['height_in_inches'],
                'qty' => $product['qty'],
                'price' => $product['price'],
            ]);
        }

        // adding notification
        $notification = new Notification();
        $notification->user_id = auth()->user()->id;
        $notification->title = 'New Invoice Created';
        $notification->body = auth()->user()->name . ' created a new invoice. the Invoice ID is ' . $invoice->id;
        $notification->save();

        return redirect()->route('invoice.show', ['invoice' => $invoice->id])->with('success', 'Invoice created successfully!');
    }

    public function render()
    {
        return view('livewire.invoice-create');
    }
}