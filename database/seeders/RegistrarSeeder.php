<?php

namespace Database\Seeders;

use App\Models\Registrar;
use Illuminate\Database\Seeder;

class RegistrarSeeder extends Seeder
{
  public function run(): void
  {
    Registrar::factory()
      ->count(5)
      ->create();
  }
}
