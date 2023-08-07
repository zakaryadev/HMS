<?php

namespace Database\Seeders;

use App\Models\PaidStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaidStatusSeeder extends Seeder
{
  public function run(): void
  {
    PaidStatus::create([
      'name' => 'оплачено',
    ]);

    PaidStatus::create([
      'name' => 'не оплачено',
    ]);

    PaidStatus::create([
      'name' => 'возврат',
    ]);
  }
}
