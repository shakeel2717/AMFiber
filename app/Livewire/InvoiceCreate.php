<?php

namespace App\Livewire;

use App\Models\Notification;
use App\Models\Payment;
use App\Models\Plai;
use Livewire\Component;
use App\Models\Product;
use App\Models\Party;

class InvoiceCreate extends Component
{
    public $customers;
    public $products;
    public $plais;
    public $selectedPlai;
    public $selectedCustomer;
    public $selectedProduct;
    public $productQty = 1;
    public $width_in_feet = '';
    public $width_in_inches = '';
    public $height_in_feet = '';
    public $height_in_inches = '';

    public $selectedProducts = [];
    public $quantities = [];
    public $totalAmount = 0;

    public $discount = 0;
    public $advance = 0;
    public $discounted_amount;
    public $without_discounted_amount;
    public $customerSearch = '';

    public function mount()
    {
        $this->customers = Party::where('type', 'customer')->get();
        $this->products = \App\Models\Product::get();
        $this->plais = \App\Models\Plai::get();
    }

    public function updatedCustomerSearch()
    {
        if (!empty($this->customerSearch)) {
            // Perform server-side search
            $this->customers = Party::where('type', 'customer')
                ->when($this->customerSearch, function ($query) {
                    return $query->where(function ($q) {
                        $q->where('name', 'like', '%' . $this->customerSearch . '%')
                            ->orWhere('phone', 'like', '%' . $this->customerSearch . '%');
                    });
                })
                ->limit(50) // Limit results to prevent overwhelming the select
                ->get();
        } else {
            $this->customers = Party::where('type', 'customer')->get();
        }
    }

    // Method to clear search and reset customers
    public function clearCustomerSearch()
    {
        $this->customerSearch = '';
        $this->customers = Party::where('type', 'customer')->get();
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
            $squareFeet = $this->totalSquareFeet();

            // getting selected Plai
            $plai = Plai::find($this->selectedPlai);

            // Calculate total price (sqft * price * qty)
            $totalPrice = $squareFeet * $plai->price * $this->productQty;

            $this->selectedProducts[] = [
                'id' => $product->id,
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

            // Store quantities
            $this->quantities[$product->id] = $this->productQty;

            // Reset inputs
            $this->productQty = 1;

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


    public function calculateTotal()
    {
        if ($this->selectedPlai) {
            $total = $this->totalAmount = array_sum(array_column($this->selectedProducts, 'total'));
            $this->without_discounted_amount = $total;
            if ($this->discount > 0) {
                $this->discounted_amount = $this->discount;
                $this->totalAmount = $total - $this->discount;
            } else {
                $this->discount = 0;
                $this->totalAmount = array_sum(array_column($this->selectedProducts, 'total'));
            }
        }
    }

    public function createInvoice()
    {
        $this->calculateTotal();

        $invoice = \App\Models\Invoice::create([
            'customer_id' => $this->selectedCustomer,
            'total_amount' => $this->totalAmount,
            'discount' => $this->discount,
            'advance' => $this->advance,
        ]);

        foreach ($this->selectedProducts as $product) {
            \App\Models\InvoiceProduct::create([
                'product_id' => $product['id'],
                'invoice_id' => $invoice->id,
                'plai_id' => $product['plai_id'],
                'width_in_feet' => $product['width_in_feet'],
                'width_in_inches' => $product['width_in_inches'],
                'height_in_feet' => $product['height_in_feet'],
                'height_in_inches' => $product['height_in_inches'],
                'qty' => $product['qty'],
                'price' => $product['price'],
            ]);
        }

        // adding advance payment
        if ($this->advance > 0) {
            $payment = new Payment();
            $payment->party_id = $this->selectedCustomer;
            $payment->amount = $this->advance;
            $payment->payment_method = 'Cash';
            $payment->reference = 'Advance Payment for Invoice #' . $invoice->id;
            $payment->save();
        }

        // adding notification
        $notification = new Notification();
        $notification->user_id = auth()->user()->id;
        $notification->title = 'New Invoice Created';
        $notification->body = auth()->user()->name . ' created a new invoice. the Invoice ID is ' . $invoice->id;
        $notification->redirect_url = route('invoice.show', ['invoice' => $invoice->id]);
        $notification->save();

        return redirect()->route('invoice.show', ['invoice' => $invoice->id])->with('success', 'Invoice created successfully!');
    }

    public function totalSquareFeet()
    {
        $totalWidthInInches = ($this->width_in_feet * 12) + $this->width_in_inches;

        // Convert height to inches
        $totalHeightInInches = ($this->height_in_feet * 12) + $this->height_in_inches;

        // Calculate square inches
        $squareInches = $totalWidthInInches * $totalHeightInInches;

        // Convert square inches to square feet
        return $squareInches / 144;
    }

    public function render()
    {
        return view('livewire.invoice-create');
    }
}
