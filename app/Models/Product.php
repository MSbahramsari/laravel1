<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use hasfactory;
    protected $fillable = [
        'product_name',
        'price',
        'amount_available',
        'sold_number',
        'explanation',
    ];




    use softDeletes ;


    public function orders() {
        return $this->belongsToMany(Order::class);
    }
}
