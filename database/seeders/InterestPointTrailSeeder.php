<?php

namespace Database\Seeders;

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
            // Récupère des infos dans jeuTest.json
            $data = JsonHelper::readJson('/jeuTest.json');
            // Récupère la collection des sentiers
            $trails = collect($data['sentiers']);

            foreach ($trails as $trail) {
                // Récupère l'ID du sentier par son titre
                $trailId = JsonHelper::getInfoByValue('trails', 'name', $trail['titre']);
                // Trouve le sentier par son ID
                $trailDatas = Trail::find($trailId);
                // Récupère les points d'intérêt associés au sentier
                $interestPoints = $trail['points_interet'];

                if ($trailDatas) {
                    // Récupère les IDs des points d'intérêt
                    $interestPointIds = collect($interestPoints)->map(function ($point) {
                        return JsonHelper::getInfoByValue('interest_points', 'name', $point['nom']);
                    })->filter()->all();

                    // Attache les points d'intérêt sans détacher les existants
                    $trailDatas->interest_points()->syncWithoutDetaching($interestPointIds);
                }
            }
        } catch (\Exception $e) {
            $this->command->error($e->getMessage());
        }
    }
}
