<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasUuids;

    // MODIFIKASI ARRAY DI BAWAH INI
    protected $fillable = [
        'name',
        'price',
        'description',
        'image',
        'stock' // Tambahkan 'stock' di sini
    ];

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }
}
