<?php

namespace App\Livewire;

use App\Models\customer;
use App\Models\Notification;
use App\Models\Party;
use App\Models\Quotation;
use App\Models\QuotationItem;
use Livewire\Component;

class QuotationCreate extends Component
{
    public $customerSearch = '';
    public $width;
    public $height;
    public $specification;
    public $truss;
    public $shed;
    public $piller;
    public $thickness;
    public $price;

    public $selectedItems = [];
    public $customers = [];
    public $selectedCustomer = null;
    public $totalAmount = 0;

    public function mount()
    {
        $this->customers = Party::where('type', 'customer')->get();
    }
 

    public function updatedCustomerSearch()
    {
        // Get customers based on the search query (name or phone)
        $this->customers = customer::where('name', 'like', '%' . $this->customerSearch . '%')
            ->orWhere('phone', 'like', '%' . $this->customerSearch . '%')
            ->get();
    }

    // Method to clear search and reset customers
    public function clearCustomerSearch()
    {
        $this->customerSearch = '';
        $this->customers = Party::where('type', 'customer')->get();
    }

    public function addItem()
    {
        if ($this->width && $this->height && $this->price) {
            $squareFeet = $this->width * $this->height;
            $total = $this->price * $squareFeet;

            $this->selectedItems[] = [
                'id' => uniqid(),
                'width' => $this->width,
                'height' => $this->height,
                'size' => $this->width . 'x' . $this->height,
                'specification' => $this->specification,
                'truss' => $this->truss,
                'shed' => $this->shed,
                'piller' => $this->piller,
                'thickness' => $this->thickness,
                'price' => $this->price,
                'total' => $total,
            ];

            // Reset input fields after adding item
            $this->resetInputFields();

            // Recalculate total
            $this->calculateTotal();
        }
    }

    public function removeItem($id)
    {
        // Find item by unique ID and remove it
        $this->selectedItems = array_filter($this->selectedItems, function ($item) use ($id) {
            return $item['id'] !== $id;
        });

        // Recalculate total
        $this->calculateTotal();
    }

    public function calculateTotal()
    {
        // Calculate total of all selected items
        $this->totalAmount = array_sum(array_column($this->selectedItems, 'total'));
    }

    public function resetInputFields()
    {
        // Clear all input fields
        $this->width = null;
        $this->height = null;
        $this->specification = null;
        $this->truss = null;
        $this->shed = null;
        $this->piller = null;
        $this->thickness = null;
        $this->price = null;
    }

    public function createQuotation()
    {
        $quotation = new Quotation();
        $quotation->customer_id = $this->selectedCustomer;
        $quotation->total_amount = $this->totalAmount;
        $quotation->save();

        foreach ($this->selectedItems as $item) {
            if (!isset($item['id'])) {
                $this->dispatch('error', 'Please add item first!');
                return;
            }

            $quotationItem = new QuotationItem();
            $quotationItem->quotation_id = $quotation->id;
            $quotationItem->width = $item['width'];
            $quotationItem->height = $item['height'];
            $quotationItem->specification = $item['specification'];
            $quotationItem->truss = $item['truss'];
            $quotationItem->shed = $item['shed'];
            $quotationItem->piller = $item['piller'];
            $quotationItem->thickness = $item['thickness'];
            $quotationItem->price = $item['price'];
            $quotationItem->total = $item['total'];
            $quotationItem->save();
        }

        $this->resetInputFields();

        // adding notification
        $notification = new Notification();
        $notification->user_id = auth()->user()->id;
        $notification->title = 'New Quotation Created';
        $notification->body = auth()->user()->name . ' created a new Quotation. the Quotation ID is ' . $quotation->id;
        $notification->redirect_url = route('quotation.show', ['quotation' => $quotation->id]);
        $notification->save();

        return redirect()->route('quotation.show', ['quotation' => $quotation->id])->with('success', 'Quotation created successfully!');
    }

    public function render()
    {
        return view('livewire.quotation-create', ['customers' => $this->customers]);
    }
}
