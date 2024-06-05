<?php

namespace App\Http\Controllers;

use App\Models\InterestPoint;
use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    //
    public static function createLocation($string_rqt)
    {
        $id = null;
        $datas = explode(',', $string_rqt); // actuellement, à voir dans le futur
        $location = Location::create([
            'latitude' => $datas[0],
            'longitude' => $datas[1]
        ]);
        $id = $location->id;

        return $id;
    }

    /*
        FOR UPDATE 
        Test if the location send by the form is still the same as the location logged in the DB for this IP
        If not, it create a new Location and return the new ID
    */
    public static function tryIdLocationOrNew($id_IP, $string)
    {

        $interest_point = InterestPoint::findOrFail($id_IP);
        $id = $interest_point->location_id;

        $datas = explode(',', $string); // À changer plus tard une fois la map faite
        $loc = Location::where('latitude', '=', $datas[0])->where('longitude', '=', $datas[1])->first();
        if ($loc) {
            if ($loc->id == $id) {
                return $id;
            }
        } else {
            $new_loc = Location::create(['latitude' => $datas[0], 'longitude' => $datas[1]]);
            $id = $new_loc->id;
        }
        return $id;
    }
}
