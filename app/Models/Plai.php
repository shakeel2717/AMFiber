<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plai extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
