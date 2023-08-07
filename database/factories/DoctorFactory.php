<?php

namespace Database\Factories;

use App\Models\Position;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class DoctorFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => $this->faker->numberBetween(1, 5),
            'position_id' => $this->faker->numberBetween(1, 5)
        ];
    }
}
