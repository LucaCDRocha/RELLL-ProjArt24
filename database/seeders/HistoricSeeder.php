<?php

namespace Database\Seeders;

use App\Models\Historic;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HistoricSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Historic::create([
            'user_id' => 2,
            'trail_id' => 1
        ]);
        Historic::create([
            'user_id' => 2,
            'trail_id' => 2
        ]);
        Historic::create([
            'user_id' => 3,
            'trail_id' => 2
        ]);
    }
}
