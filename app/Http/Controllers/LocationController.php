<?php

namespace App\Http\Controllers;

use App\Models\InterestPoint;
use App\Models\Location;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    //
    public static function createLocation($arr_loc)
    {
        $location = Location::create([
            'latitude' => $arr_loc['latLng']['lat'],
            'longitude' => $arr_loc['latLng']['lng']
        ]);

        return $location->id;
    }

    /*
        FOR UPDATE 
        Test if the location send by the form is still the same as the location logged in the DB for this IP
        If not, it create a new Location and return the new ID
    */
    public static function tryIdLocationOrNew($id_IP, $arr_loc)
    {
        $interest_point = InterestPoint::findOrFail($id_IP);
        $id = $interest_point->location_id;

        $loc = Location::where('latitude', '=', $arr_loc['latLng']['lat'])->where('longitude', '=', $arr_loc['latLng']['lng'])->first();
        if ($loc) {
            if ($loc->id == $id) {
                return $id;
            }
        } else {
            $new_loc = Location::create(['latitude' => $arr_loc['latLng']['lat'], 'longitude' => $arr_loc['latLng']['lng']]);
            $id = $new_loc->id;
        }
        return $id;
    }
}
