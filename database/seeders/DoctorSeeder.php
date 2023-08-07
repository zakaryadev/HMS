<?php

namespace Database\Seeders;

use App\Models\Doctor;
use Illuminate\Database\Seeder;

class DoctorSeeder extends Seeder
{
  public function run(): void
  {
    Doctor::factory()
      ->count(5)
      ->create();
  }
}
