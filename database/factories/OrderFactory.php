<?php

namespace Database\Factories;

use App\Models\Cashier;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Registrar;
use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    public function definition(): array
    {
        return [
            'service_id' => Service::factory(),
            'registrar_id' => Registrar::factory(),
            'doctor_id' => Doctor::factory(),
            'cashier_id' => Cashier::factory(),
            'patient_id' => Patient::factory(),
            'paid_status_id' => rand(1, 3),
            'price' => rand(100000, 1000000),
            'destination' => $this->faker->word(),
        ];
    }
}
