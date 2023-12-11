<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'total_price',
    ];
    public function user() {
    return $this->belongsTo(User::class);
    }
    public function products() {
    return $this->belongsToMany(Product::class)->withPivot('count');
    }
    use softDeletes ;
//    public function pivot() {
//        return $this->belongsToMany(Order_product::class);
//    }
}
