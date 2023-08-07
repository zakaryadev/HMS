<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function doctors()
    {
        return $this->hasMany(Doctor::class);
    }

    public function services()
    {
        return $this->hasMany(Service::class);
    }
}
