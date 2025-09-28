<?php

namespace App\Livewire;

use App\Models\Invoice;
use App\Models\InvoiceProduct;
use App\Models\Notification;
use App\Models\Payment;
use App\Models\Plai;
use App\Models\Product;
use App\Models\Party;
use Livewire\Component;

class InvoiceEdit extends Component
{
    public $invoice;
    public $products;
    public $plais;
    public $selectedPlai;
    public $selectedProduct;
    public int $productQty = 1;
    public $width_in_feet = '';
    public $width_in_inches = '';
    public $height_in_feet = '';
    public $height_in_inches = '';

    public $invoiceProducts = [];
    public $totalAmount = 0;
    public $discount = 0;
    public $advance = 0;
    public $discounted_amount = 0;
    public $without_discounted_amount = 0;

    public function mount($invoice)
    {
        $this->invoice = $invoice;
        $this->products = Product::all();
        $this->plais = Plai::all();
        $this->discount = $invoice->discount;
        $this->advance = $invoice->advance;
        
        // Load existing invoice products
        $this->invoiceProducts = $invoice->invoice_products->map(function ($item) {
            return [
                'id' => $item->id,
                'product_id' => $item->product_id,
                'name' => $item->product->name,
                'plai_id' => $item->plai_id,
                'width_in_feet' => $item->width_in_feet,
                'width_in_inches' => $item->width_in_inches,
                'height_in_feet' => $item->height_in_feet,
                'height_in_inches' => $item->height_in_inches,
                'qty' => $item->qty,
                'price' => $item->price,
                'total' => $item->totalSquareFeet() * $item->price * $item->qty,
            ];
        })->toArray();

        $this->calculateTotal();
    }

    public function addProduct()
    {
        if ($this->width_in_feet == '') {
            $this->width_in_feet = 0;
        }
        if ($this->width_in_inches == '') {
            $this->width_in_inches = 0;
        }
        if ($this->height_in_feet == '') {
            $this->height_in_feet = 0;
        }
        if ($this->height_in_inches == '') {
            $this->height_in_inches = 0;
        }

        if (
            $this->selectedProduct
            && ($this->width_in_feet > 0 || $this->width_in_inches > 0)
            && ($this->height_in_feet > 0 || $this->height_in_inches > 0)
        ) {
            $product = $this->products->find($this->selectedProduct);
            $plai = Plai::find($this->selectedPlai);
            $squareFeet = $this->totalSquareFeet();
            $totalPrice = $squareFeet * $plai->price * $this->productQty;

            $this->invoiceProducts[] = [
                'id' => null, // New product
                'product_id' => $product->id,
                'name' => $product->name,
                'plai_id' => $plai->id,
                'width_in_feet' => $this->width_in_feet,
                'width_in_inches' => $this->width_in_inches,
                'height_in_feet' => $this->height_in_feet,
                'height_in_inches' => $this->height_in_inches,
                'qty' => $this->productQty,
                'price' => $plai->price,
                'total' => $totalPrice,
            ];

            // $this->resetInputs();
            $this->calculateTotal();
        } else {
            $this->dispatch('error', status: 'Please select product and enter dimensions');
        }
    }

    public function removeProduct($index)
    {
        $product = $this->invoiceProducts[$index];
        
        // If it's an existing product, delete from database
        if ($product['id']) {
            InvoiceProduct::destroy($product['id']);
        }
        
        unset($this->invoiceProducts[$index]);
        $this->invoiceProducts = array_values($this->invoiceProducts);
        $this->calculateTotal();
    }

    public function updateProduct($index, $field, $value)
    {
        $this->invoiceProducts[$index][$field] = $value;
        
        // Recalculate total for this product
        $product = $this->invoiceProducts[$index];
        $squareFeet = $this->calculateSquareFeetForProduct($product);
        $this->invoiceProducts[$index]['total'] = $squareFeet * $product['price'] * $product['qty'];
        
        $this->calculateTotal();
    }

    private function calculateSquareFeetForProduct($product)
    {
        $totalWidthInInches = ($product['width_in_feet'] * 12) + $product['width_in_inches'];
        $totalHeightInInches = ($product['height_in_feet'] * 12) + $product['height_in_inches'];
        $squareInches = $totalWidthInInches * $totalHeightInInches;
        return $squareInches / 144;
    }

    public function calculateTotal()
    {
        $total = array_sum(array_column($this->invoiceProducts, 'total'));
        $this->without_discounted_amount = $total;
        
        if ($this->discount > 0) {
            $this->discounted_amount = $this->discount;
            $this->totalAmount = $total - $this->discount;
        } else {
            $this->discount = 0;
            $this->totalAmount = $total;
        }
    }

    public function updateInvoice()
    {
        $this->calculateTotal();

        // Update invoice
        $this->invoice->update([
            'total_amount' => $this->totalAmount,
            'discount' => $this->discount,
            'advance' => $this->advance,
        ]);

        // Delete existing products and recreate them
        InvoiceProduct::where('invoice_id', $this->invoice->id)->delete();

        foreach ($this->invoiceProducts as $product) {
            InvoiceProduct::create([
                'product_id' => $product['product_id'],
                'invoice_id' => $this->invoice->id,
                'plai_id' => $product['plai_id'],
                'width_in_feet' => $product['width_in_feet'],
                'width_in_inches' => $product['width_in_inches'],
                'height_in_feet' => $product['height_in_feet'],
                'height_in_inches' => $product['height_in_inches'],
                'qty' => $product['qty'],
                'price' => $product['price'],
            ]);
        }

        // Handle advance payment update
        $existingAdvancePayment = Payment::where('party_id', $this->invoice->customer_id)
            ->where('reference', 'like', 'Advance Payment for Invoice #' . $this->invoice->id)
            ->first();

        if ($this->advance > 0) {
            if ($existingAdvancePayment) {
                $existingAdvancePayment->update(['amount' => $this->advance]);
            } else {
                Payment::create([
                    'party_id' => $this->invoice->customer_id,
                    'amount' => $this->advance,
                    'payment_method' => 'Cash',
                    'reference' => 'Advance Payment for Invoice #' . $this->invoice->id,
                ]);
            }
        } elseif ($existingAdvancePayment) {
            $existingAdvancePayment->delete();
        }

        // Add notification
        Notification::create([
            'user_id' => auth()->id(),
            'title' => 'Invoice Updated',
            'body' => auth()->user()->name . ' updated invoice #' . $this->invoice->id,
            'redirect_url' => route('invoice.show', ['invoice' => $this->invoice->id]),
        ]);

        return redirect()->route('invoice.show', ['invoice' => $this->invoice->id])
            ->with('success', 'Invoice updated successfully!');
    }

    private function resetInputs()
    {
        $this->selectedProduct = null;
        $this->selectedPlai = null;
        $this->productQty = 1;
        $this->width_in_feet = '';
        $this->width_in_inches = '';
        $this->height_in_feet = '';
        $this->height_in_inches = '';
    }

    public function totalSquareFeet()
    {
        $totalWidthInInches = ($this->width_in_feet * 12) + $this->width_in_inches;
        $totalHeightInInches = ($this->height_in_feet * 12) + $this->height_in_inches;
        $squareInches = $totalWidthInInches * $totalHeightInInches;
        return $squareInches / 144;
    }

    public function render()
    {
        return view('livewire.invoice-edit');
    }
}