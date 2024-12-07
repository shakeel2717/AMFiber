<?php

namespace App\Livewire;

use App\Models\customer;
use App\Models\Party;
use App\Models\Payment;
use Livewire\Component;

class PaymentCreate extends Component
{


        public $selectedCustomer = null;
        public $search = '';  // Added property for search term
        public $amount = '';
        public $reduction = '';
        public $payment_method = 'Cash';
        public $reference = '';
    
        public $customers = [];
    
        protected $rules = [
            'selectedCustomer' => 'required|exists:customers,id',
            'amount' => 'required|numeric|min:0',
            'reduction' => 'nullable|numeric|min:0',
            'payment_method' => 'required|string',
            'reference' => 'nullable|string',
        ];
    
        // Filter customers based on search
        public function updatedSearch()
        {
            $this->customers =customer::where('id', 'like', '%' . $this->search . '%')
                ->orWhere('name', 'like', '%' . $this->search . '%')
                ->orWhere('email', 'like', '%' . $this->search . '%')
                ->orWhere('phone', 'like', '%' . $this->search . '%')
                ->get();
        }
    
        public function mount()
        {
            $this->customers = Customer::all(); // Get all customers initially
        }
    
        public function submit()
        {
            $this->validate(); // Validate the form data
    
            Payment::create([
                'customer_id' => $this->selectedCustomer,
                'amount' => $this->amount,
                'reduction' => $this->reduction,
                'payment_method' => $this->payment_method,
                'reference' => $this->reference,
            ]);
    
            session()->flash('success', 'Payment added successfully!'); // Success message
        }
    
      
   
    public function render()
    {
        return view('livewire.payment-create');
         
    }
}
