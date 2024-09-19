<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Party extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'address',
        'type',
    ];

    public function balance()
    {
        $invoicesAmount = Invoice::where('customer_id', $this->id)
            ->with('invoice_products') // Load related invoice products
            ->get()
            ->sum(function ($invoice) {
                // Calculate the total amount for the invoice before discount
                $invoiceTotal = $invoice->invoice_products->sum(function ($product) {
                    return $product->width * $product->height * $product->qty * $product->price;
                });

                // Apply discount if exists
                $discountedTotal = $invoiceTotal * (1 - ($invoice->discount / 100));

                return $discountedTotal;
            });
        $payments = Payment::where('party_id', $this->id)->sum('amount');

        return $invoicesAmount - $payments;
    }
}
