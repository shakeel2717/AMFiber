<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'width',
        'height',
        'specification',
        'truss',
        'shed',
        'piller',
        'thickness',
        'price',
        'total_amount'
    ];


    public function party()
    {
        return $this->belongsTo(Party::class, 'customer_id', 'id');
    }

    public function quotation_items()
    {
        return $this->hasMany(QuotationItem::class);
    }
}
