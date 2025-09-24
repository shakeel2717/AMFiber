<?php

namespace App\Livewire;

use App\Models\Party;
use App\Models\Invoice;
use Livewire\Component;

class PaymentCreate extends Component
{
    public $customerSearch = '';
    public $selectedCustomer = '';
    public $customers = [];
    public $invoices = [];
    public $selectedInvoice = '';

    public function mount()
    {
        $this->customers = Party::where('type', 'customer')->get();
    }

    public function updatedSelectedCustomer()
    {
        if ($this->selectedCustomer) {
            $this->invoices = Invoice::where('customer_id', $this->selectedCustomer)
                ->where('status', false) // Only unpaid invoices
                ->get();
        } else {
            $this->invoices = [];
        }
        $this->selectedInvoice = '';
    }

    public function updatedCustomerSearch()
    {
        if (!empty($this->customerSearch)) {
            $this->customers = Party::where('type', 'customer')
                ->when($this->customerSearch, function ($query) {
                    return $query->where(function ($q) {
                        $q->where('name', 'like', '%' . $this->customerSearch . '%')
                            ->orWhere('phone', 'like', '%' . $this->customerSearch . '%');
                    });
                })
                ->limit(50)
                ->get();
        } else {
            $this->customers = Party::where('type', 'customer')->get();
        }
    }

    public function clearCustomerSearch()
    {
        $this->customerSearch = '';
        $this->customers = Party::where('type', 'customer')->get();
    }

    public function render()
    {
        return view('livewire.payment-create');
    }
}