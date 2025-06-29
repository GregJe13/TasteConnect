<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasUuids;

    protected $fillable = [
        'title',
        'discountAmount',
        'startDate',
        'endDate',
    ];
}
