<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class CustomerLoyalty extends Model
{
    use HasUuids;

    protected $fillable = [
        'customer_id',
        'loyalty_program_id',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function loyaltyProgram()
    {
        return $this->belongsTo(LoyaltyProgram::class);
    }
}
