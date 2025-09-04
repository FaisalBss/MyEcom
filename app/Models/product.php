<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    use HasFactory;

protected $fillable = [
    'name', 'price', 'quantity', 'category_id', 'description', 'image'
];

public function carts()
    {
        return $this->hasMany(Cart::class);
    }


    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
