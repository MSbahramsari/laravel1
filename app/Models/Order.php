<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'total_price',
    ];
    public function users() {
    return $this->belongsTo(User::class);
    }
    public function products() {
    return $this->belongsToMany(Product::class)->withPivot('count');
    }
//    public function pivot() {
//        return $this->belongsToMany(Order_product::class);
//    }
}
