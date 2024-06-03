<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Helpers\JsonHelper;
use App\Models\Img;

class ImgSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            $data = JsonHelper::readJson('/jeuTest.json'); //récupère des infos dans jeuTest.json

            //ajout des images des sentiers
            // TODO: faire le seeder pour les images des sentiers
            $imageTrails = collect($data['sentiers'])
                ->pluck('image');

            dump($imageTrails);

            foreach ($imageTrails as $image) {
                dump($image);
                //  Img::create([
                //     'source' => $image['source'],
                //     'url' => $image['url'],
                //      'created_at' => now(),
                //      'updated_at' => now(),
                //  ]);
            }

            //ajout des images des points d'intérêts
            $pointsInterets = collect($data['sentiers'])
                ->pluck('points_interet') //extrait les valeurs d'un attribut donné de chaque élément de la collection
                ->flatten(1);

            foreach ($pointsInterets as $point) {

                $idPI = JsonHelper::getInfoByValue('interest_points', 'name', $point['nom']);

                $images = $point['images'];

                foreach ($images as $image) {

                    Img::create([
                        'interest_point_id' => $idPI,
                        'source' => $image['source'],
                        'img_path' => $image['url'],
                    ]);
                }
            }
        } catch (\Exception $e) {
            $this->command->error($e->getMessage());
        }
    }
}
