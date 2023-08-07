<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            SexSeeder::class,
            UserSeeder::class,
            PositionSeeder::class,
            ServiceSeeder::class,
            PaidStatusSeeder::class,
            DoctorSeeder::class,
            OrderSeeder::class,
        ]);
    }
}
