<?php

namespace App\Helpers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class JsonHelper
{
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