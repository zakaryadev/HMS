<?php

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Seeder;

class PositionSeeder extends Seeder
{
  public function run(): void
  {
    Position::factory()
      ->count(5)
      ->create();
  }
}
