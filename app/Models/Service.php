<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'position_id',
        'name',
        'price',
    ];

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
