<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PatientFactory extends Factory
{
    public function definition(): array
    {
        return [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'sur_name' => $this->faker->lastName(),
            'phone_number' => 901234567,
            'date_birth' => $this->faker->date(),
            'sex_id' => $this->faker->numberBetween(1, 2),
        ];
    }
}
