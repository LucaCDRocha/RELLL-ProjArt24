<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\Tag;
use App\Helpers\JsonHelper;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            $data = JsonHelper::readJson('/jeuTest.json'); //récupère des infos dans jeuTest.json

        // Extraire les tags uniques
        $tags = collect($data['sentiers'])
                    ->pluck('points_interet') //extrait les valeurs d'un attribut donné de chaque élément de la collection
                    ->flatten(1) //aplatie la collection d'un niveau
                    ->pluck('tag')
                    ->unique()
                    ->values()
                    ->all();

        // Insérer les tags dans la base de données
        foreach ($tags as $tag) {
           Tag::create([
                'name' => $tag
            ]);
        }
    } catch (\Exception $e) {
            $this->command->error($e->getMessage());
        }
    }
}
