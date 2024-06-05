<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Helpers\JsonHelper;
use App\Models\InterestPoint;

class InterestPointTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            // Récupère des infos dans jeuTest.json
            $data = JsonHelper::readJson('/jeuTest.json'); 
            // Extrait les valeurs de l'attribut 'points_interet' de chaque élément de la collection 'sentiers'
            $interestPoints = collect($data['sentiers'])
                ->pluck('points_interet')
                ->flatten(1);

            foreach ($interestPoints as $interestPoint) {
                // Récupère l'ID du point d'intérêt par son nom
                $interestPointId = JsonHelper::getInfoByValue('interest_points', 'name', $interestPoint['nom']);
                // Trouve le point d'intérêt par son ID
                $interestPointDatas = InterestPoint::find($interestPointId);
                // Récupère les tags associés au point d'intérêt
                $tags = $interestPoint['tags'];

                if ($interestPointDatas) {
                    // Récupère les IDs des tags
                    $tagIds = collect($tags)->map(function ($tagName) {
                        return JsonHelper::getInfoByValue('tags', 'name', $tagName);
                    })->filter()->all();

                    // Attache les tags sans détacher les existants
                    $interestPointDatas->tags()->syncWithoutDetaching($tagIds);
                }
            }
        } catch (\Exception $e) {
            $this->command->error($e->getMessage());
        }
    }
}
