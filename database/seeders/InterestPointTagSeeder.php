<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
            $data = JsonHelper::readJson('/jeuTest.json'); //récupère des infos dans jeuTest.json
            $interestPoints = collect($data['sentiers'])
                ->pluck('points_interet') //extrait les valeurs d'un attribut donné de chaque élément de la collection
                ->flatten(1);

            foreach ($interestPoints as $interestPoint) {

                $interestPointId = JsonHelper::getInfoByValue('interest_points', 'name', $interestPoint['nom']);
                $interestPointDatas = InterestPoint::find($interestPointId);
                $tags = $interestPoint['tags'];

                for ($i = 0; $i < count($tags); $i++) {
                    $tagId = JsonHelper::getInfoByValue('tags', 'name', $tags[$i]);

                    $interestPointDatas->tags()->attach($tagId);
                }
            }
        } catch (\Exception $e) {
            $this->command->error($e->getMessage());
        }
    }
}
