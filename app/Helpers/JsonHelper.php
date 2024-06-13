<?php

namespace App\Helpers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class JsonHelper
{
    /**
     * Lire un fichier JSON
     *
     * @param string $filePath
     * @return array
     * @throws \Exception
     */
    public static function readJson($filePath)
    {
        $jsonPath = database_path($filePath);

        // Lire le fichier JSON
        if (!File::exists($jsonPath)) {
            throw new \Exception("File not found: {$jsonPath}");
        }

        $jsonData = File::get($jsonPath);
        return json_decode($jsonData, true);
    }

    /**
     * Trouver l'ID d'une location par ses coordonnées
     * 
     * @param array $coordinates
     * @return int|null
     * @throws \Exception
     */
    public static function getLocationIdByCoordinates($coordinates)
    {
        $location = DB::table('locations')
                      ->where('latitude', $coordinates[0])
                      ->where('longitude', $coordinates[1])
                      ->first();

        if ($location) {
            return $location->id;
        } else {
            return null;
        }
    }

    /**
     * Trouver l'ID d'une valeur dans une table
     * 
     * @param string $table
     * @param string $field
     * @param string $value
     * @return int|null
     * @throws \Exception
     */
    public static function getInfoByValue($table, $field, $value)
    {
        $data = DB::table($table)
                      ->where($field, $value)
                      ->first();

        if ($data) {
            return $data->id;
        } else {
            return null;
        }
    }
}