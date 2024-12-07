<?php

namespace App\Livewire;

use App\Models\Party;
use Livewire\Component;

class PaymentCreate extends Component
{
    public $customerSearch = ''; // Search term
    public $customers = []; // Initialize the customers array

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
    public function render()
    {
        return view('livewire.payment-create', ['customers' => $this->customers]); // Pass customers to the view
    }
}
