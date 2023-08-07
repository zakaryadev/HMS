<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'registrar_id',
        'patient_id',
        'doctor_id',
        'cashier_id',
        'paid_status_id',
        'payment_method_id',
        'destination',
        'price'
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function registrar()
    {
        return $this->belongsTo(Registrar::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function cashier()
    {
        return $this->belongsTo(Cashier::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function paid_status()
    {
        return $this->belongsTo(PaidStatus::class);
    }

    public function payment_method()
    {
        return $this->belongsTo(PaymentMethods::class);
    }

    public function hybrid_paids()
    {
        return $this->hasMany(HybridPaids::class);
    }

    public function debts()
    {
        return $this->hasMany(Debts::class);
    }
}
