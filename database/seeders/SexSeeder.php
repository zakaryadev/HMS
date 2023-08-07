<?php

namespace Database\Seeders;

use App\Models\Sex;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SexSeeder extends Seeder
{
    public function run(): void
    {
        Sex::create([
            'name' => 'мужчина',
        ]);

        Sex::create([
            'name' => 'женщина',
        ]);
    }
}
