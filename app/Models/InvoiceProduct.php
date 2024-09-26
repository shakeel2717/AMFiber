<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceProduct extends Model
{
    use HasFactory;


    protected $fillable = ['product_id', 'qty', 'invoice_id', 'plai_id', 'width_in_feet', 'width_in_inches', 'height_in_feet', 'height_in_inches', 'price'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function plai()
    {
        return $this->belongsTo(Plai::class);
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
}
