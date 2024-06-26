<?php

namespace Database\Seeders;

use App\Models\Ranking;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Helpers\JsonHelper;

class RankingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            $data = JsonHelper::readJson('/interactionsTest.json'); //récupère des infos dans le JSON
            $rankings = collect($data['rankings']);

            foreach ($rankings as $ranking) {
                $trailId = JsonHelper::getInfoByValue('trails', 'name', $ranking['trail']);
                $userId = JsonHelper::getInfoByValue('users', 'name', $ranking['user']);

                $date = date("2024-06-10 00:00:00");

                Ranking::updateOrCreate([
                    'note' => $ranking['note'],
                    'trail_id' => $trailId,
                    'user_id' => $userId,
                    'created_at' => $date,
                    'updated_at' => $date,
                ]);
            }
        } catch (\Exception $e) {
            $this->command->error($e->getMessage());
        }
    }
}
