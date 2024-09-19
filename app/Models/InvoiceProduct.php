<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceProduct extends Model
{
    use HasFactory;


    protected $fillable = ['product_id', 'qty', 'invoice_id', 'width', 'height','price'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
