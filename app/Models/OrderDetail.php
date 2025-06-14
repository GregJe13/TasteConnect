<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasUuids;

    protected $fillable = [
        'order_id',
        'menu_id',
        'quantity',
        'price',
    ];
    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

   
}
