<?php

namespace Database\Seeders;

use App\Models\InterestPoint;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Helpers\JsonHelper;

class InterestPointSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            $data = JsonHelper::readJson('/jeuTest.json'); //récupère des infos dans jeuTest.json

            $PIs = collect($data['sentiers'])
                ->pluck('points_interet') //extrait les valeurs d'un attribut donné de chaque élément de la collection
                ->flatten(1);

            foreach ($PIs as $point) {
                $coordinates = $point['coordonnees'];
                $locationId = JsonHelper::getLocationIdByCoordinates($coordinates);

                InterestPoint::updateOrCreate([
                    'name' => $point['nom'],
                    'description' => $point['description'],
                    'open_seasons' => $point['open_season'],
                    'url' => $point['url'],
                    'location_id' => $locationId,
                ]);
            }
        } catch (\Exception $e) {
            $this->command->error($e->getMessage());
        }
    }
}
