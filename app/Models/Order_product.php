<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order_product extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
    ];
//    public function orders() {
//        return $this->belongsToMany(Order::class);
//    }
}
