<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'total_amount',
    ];


    public function party()
    {
        return $this->belongsTo(Party::class, 'customer_id', 'id');
    }

    public function quotation_products()
    {
        return $this->hasMany(QuotationProduct::class);
    }
}
