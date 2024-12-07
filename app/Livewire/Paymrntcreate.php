<?php

namespace App\Livewire;

use App\Models\customer;
use App\Models\Party;
use App\Models\Payment;
use Livewire\Component;

class PaymentCreate extends Component
{


 
    public function render()
    {
        return view('livewire.payment-create');
         
    }
}
