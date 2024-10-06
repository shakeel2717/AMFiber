<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = ['customer_id', 'total_amount', 'discount', 'advance', 'status', 'type'];


    public function party()
    {
        return $this->belongsTo(Party::class, 'customer_id');
    }

    public function invoice_products()
    {
        return $this->hasMany(InvoiceProduct::class);
    }

    public function calculateSubtotal()
    {

        $total = 0;
        foreach ($this->invoice_products as $item) {
            $totalSize = $item->totalSquareFeet();
            $total += $totalSize * $item->price * $item->qty;
        }
        return $total;
    }

    public function calculateDiscount()
    {
        return $this->discount;
    }

    public function calculateGrandTotal()
    {
        return $this->calculateSubtotal() - $this->calculateDiscount() - $this->advance;
    }
}
