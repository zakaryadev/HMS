<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'sur_name',
        'phone_number',
        'date_birth',
        'address',
        'sex_id',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function sex()
    {
        return $this->belongsTo(Sex::class);
    }
}
