<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'first_name',
        'last_name',
        'sur_name',
        'phone_number',
        'date_birth',
        'login',
        'password',
        'sex_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function registrar()
    {
        return $this->hasOne(Registrar::class);
    }

    public function cashier()
    {
        return $this->hasOne(Cashier::class);
    }

    public function doctor()
    {
        return $this->hasOne(Doctor::class);
    }

    public function sex()
    {
        return $this->belongsTo(Sex::class);
    }
}
