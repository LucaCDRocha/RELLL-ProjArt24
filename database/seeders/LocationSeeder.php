<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Helpers\JsonHelper;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            $data = JsonHelper::readJson('/jeuTest.json'); //récupère des infos dans jeuTest.json

            $coordinates_depart = collect($data['sentiers'])
                ->pluck('depart')
                ->pluck('coordonnees')
                ->filter() // Filtrer les points d'intérêt sans coordonnées
                ->values()
                ->all();

            foreach ($coordinates_depart as $coordinate) {
                dump($coordinate);
                Location::create([
                    'latitude' => $coordinate[0],
                    'longitude' => $coordinate[1]
                ]);
            }

            $coordinates_arrivee = collect($data['sentiers'])
                ->pluck('arrivee')
                ->pluck('coordonnees')
                ->filter() // Filtrer les points d'intérêt sans coordonnées
                ->values()
                ->all();

            foreach ($coordinates_arrivee as $coordinate) {
                dump($coordinate);
                Location::create([
                    'latitude' => $coordinate[0],
                    'longitude' => $coordinate[1]
                ]);
            }

            // Extraire les coordonnées de tous les points d'intérêt
            $coordinates = collect($data['sentiers'])
                ->pluck('points_interet')
                ->flatten(1)
                ->pluck('coordonnees')
                ->filter() // Filtrer les points d'intérêt sans coordonnées
                ->values()
                ->all();

            // Insérer les tags dans la base de données
            foreach ($coordinates as $coordinate) {
                Location::create([
                    'latitude' => $coordinate[0],
                    'longitude' => $coordinate[1]
                ]);
            }
        } catch (\Exception $e) {
            $this->command->error($e->getMessage());
        }
    }
}
