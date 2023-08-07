<?php

namespace Database\Factories;

use App\Models\Position;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceFactory extends Factory
{
    public function definition(): array
    {
        return [
            'position_id' => $this->faker->numberBetween(1, 5),
            'name' => $this->faker->jobTitle(),
            'price' => $this->faker->numberBetween(50000, 1000000),
        ];
    }
}
