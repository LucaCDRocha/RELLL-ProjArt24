<?php

namespace Database\Seeders;

use App\Models\Trail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Helpers\JsonHelper;

class TrailsSeeder extends Seeder
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

                $difficulte = $trail['difficulte'];

                $startId = JsonHelper::getLocationIdByCoordinates($trail['depart']['coordonnees']);
                $endId = JsonHelper::getLocationIdByCoordinates($trail['arrivee']['coordonnees']);
                $parkingId = JsonHelper::getLocationIdByCoordinates($trail['parking']['coordonnees']);

                $imgId = JsonHelper::getInfoByValue('imgs', 'img_path', $trail['image']['url']);

                Trail::updateOrCreate([
                    'name' => $trail['titre'],
                    'time' => $trail['duree'],
                    'description' => $trail['description'],
                    'difficulty' => $difficulte,
                    'is_accessible' => $trail['accessibilite'],
                    'user_id' => 1,
                    'img_id' => $imgId,
                    // 'img_id' => 2,
                    'location_start_id' => $startId,
                    'location_end_id' => $endId,
                    'location_parking_id' => $parkingId,
                    'info_transport' => $trail['info_transport'],
                    // 'info_restauration' => $trail['restauration'],
                ]);
            }



        } catch (\Exception $e) {
            $this->command->error($e->getMessage());
        }
    }
}
