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

            //crée les points de départ des sentiers
            $coordinates_depart = collect($data['sentiers'])
                ->pluck('depart')
                ->pluck('coordonnees')
                ->unique()
                ->values()
                ->all();

            foreach ($coordinates_depart as $coordinate) {
                dump($coordinate);
                $locationId = JsonHelper::getLocationIdByCoordinates($coordinate);
                if ($locationId == null) {
                    Location::create([
                        'latitude' => $coordinate[0],
                        'longitude' => $coordinate[1]
                    ]);
                }
            }

            //crée les points d'arrivées des sentiers
            $coordinates_arrivee = collect($data['sentiers'])
                ->pluck('arrivee')
                ->pluck('coordonnees')
                ->unique()
                ->values()
                ->all();

            foreach ($coordinates_arrivee as $coordinate) {
                $locationId = JsonHelper::getLocationIdByCoordinates($coordinate);
                if ($locationId == null) {
                    Location::create([
                        'latitude' => $coordinate[0],
                        'longitude' => $coordinate[1]
                    ]);
                }
            }

            //crée les points des parkings des sentiers
            $coordinates_parking = collect($data['sentiers'])
                ->pluck('parking')
                ->pluck('coordonnees')
                ->unique()
                ->values()
                ->all();

            foreach ($coordinates_parking as $coordinate) {
                $locationId = JsonHelper::getLocationIdByCoordinates($coordinate);
                if ($locationId == null) {
                    Location::create([
                        'latitude' => $coordinate[0],
                        'longitude' => $coordinate[1]
                    ]);
                }
            }

            // Extrait les coordonnées de tous les points d'intérêt
            $coordinates = collect($data['sentiers'])
                ->pluck('points_interet')
                ->flatten(1)
                ->pluck('coordonnees')
                ->unique()
                ->values()
                ->all();

            // Insére les coordonnées des points dans la base de données
            foreach ($coordinates as $coordinate) {
                $locationId = JsonHelper::getLocationIdByCoordinates($coordinate);
                if ($locationId == null) {
                    Location::create([
                        'latitude' => $coordinate[0],
                        'longitude' => $coordinate[1]
                    ]);
                }
            }
        } catch (\Exception $e) {
            $this->command->error($e->getMessage());
        }
    }
}
