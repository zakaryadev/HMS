<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Debts extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'payment_method_id',
        'paid_amount',
        'owed_amount',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
