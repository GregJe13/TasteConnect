<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasUuids;

    protected $fillable = [
        'customer_id',
        'orderDate',
        'totalAmount',
        'status',
        'address',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }
}
