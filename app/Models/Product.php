<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'product_name',
        'price',
        'amount_available',
        'sold_number',
        'explanation',
    ];



    public function orders() {
        return $this->belongsToMany(Order::class);
    }
}
