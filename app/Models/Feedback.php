<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasUuids;

    protected $table = 'feedbacks';
    protected $fillable = [
        'order_id',
        'comment',
        'rating',
        'date',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
