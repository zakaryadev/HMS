<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CashierFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(5),
        ];
    }
}
