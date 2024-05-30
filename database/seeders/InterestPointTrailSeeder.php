<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Helpers\JsonHelper;
use App\Models\Trail;
use App\Models\InterestPoint;

class InterestPointTrailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            $data = JsonHelper::readJson('/jeuTest.json'); //récupère des infos dans jeuTest.json
            $trails = collect($data['sentiers']);

            foreach ($trails as $trail) {

            $trailId = JsonHelper::getInfoByValue('trails', 'name', $trail['titre']);
            $trailDatas = Trail::find($trailId);
            $interest_points = $trail['points_interet'];

            foreach ($interest_points as $point) {
                $IPId = JsonHelper::getInfoByValue('interest_points', 'name', $point['nom']);

                $trailDatas->interest_points()->attach($IPId);
            }
        }

        } catch (\Exception $e) {
            $this->command->error($e->getMessage());
        }
    }
}
