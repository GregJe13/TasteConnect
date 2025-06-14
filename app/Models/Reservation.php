<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasUuids;

    protected $fillable = ['customer_id', 'date', 'status'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
