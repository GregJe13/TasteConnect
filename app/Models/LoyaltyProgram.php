<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class LoyaltyProgram extends Model
{
    use HasUuids;

    protected $fillable = [
        'name',
        'point',
        'reward',
        'startDate',
        'endDate',
    ];
}
