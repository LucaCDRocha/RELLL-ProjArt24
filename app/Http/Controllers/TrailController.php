<?php

namespace App\Http\Controllers;

use App\Http\Requests\TrailCreateRequest;
use App\Models\Img;
use App\Models\InterestPoint;
use App\Models\Location;
use App\Models\Theme;
use App\Models\Trail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class TrailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $allTrails = Trail::all();

        return Inertia::render('Trail/TrailIndex', ['trails' => $allTrails]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $allThemes = Theme::all();
        return Inertia::render('Trail/TrailCreate', ['themes' => $allThemes]);
    }

    /**
     * Store a newly created resource in storage.
     */

    public function getTimeTrail($interest_points)
    {
        /*
            À implementer 
        */

        return now();
    }

    public function store(TrailCreateRequest $request)
    {
        // Sauvegarde d'une image dans la BD

        // Gestion du nom pour éviter les doublons

        $img_id = 1; // id: 1 -> Default Image for the Trail
        if ($request->hasFile('img')) {
            $img = Img::create(['img_path' => ""]);
            $path = "img/imgTrail/";
            $file_name = "image-" . $img->id . ".jpg";
            $img->img_path = $path . $file_name;
            $request->img->move(public_path('img/imgTrail'), $file_name);
            $img_id = $img->id;
        }

        /* 
            Sauvegarde d'un trail dans la BD
        */

        // Sauvegarde des coordonées GPS

        $loc_start_id = TrailController::createLocation($request->location_start);
        $loc_end_id = TrailController::createLocation($request->location_end);
        $loc_parking_id = TrailController::createLocation($request->location_parking);

        $inputs = // Enlever les default avant lancement de l'app
            [
                'name' => $request->name ?: "test",
                'time' => TrailController::getTimeTrail($request->time),
                'description' => $request->description ?: "description test",
                'difficulty' => $request->difficulty ?: 1,
                'is_accessible' => $request->is_accessible == 'Oui' ?: 1,
                'info_transport' => $request->info_transport ?: "Sans transports test",
                'user_id' => $request->user_id,
                'img_id' => $img_id,
                'location_start_id' => $loc_start_id ?: 1,
                'location_end_id' => $loc_end_id ?: 2,
                'location_parking_id' => $loc_parking_id ?: 3,
            ];

        $trail = Trail::create($inputs);

        /*
        Gestion des points d'interets via la table pivot 
        << Actuellement fais avec des strings, À voir si on peut modifier une fois qu'il y aura la carte >>
        */

        // le String doit arriver comme suit Latitude,Longitude;Latitude,Longitude;Latitude,Longitude;...
        $interest_points = [];
        $rawLocations = explode(';', $request->interest_points);
        $i = 0;
        foreach ($rawLocations as $rawLocation) {
            $array = explode(',', $rawLocation);
            $latitude = $array[0];
            $longitude = $array[1];
            $interest_points[$i] = ['longitude' => $longitude, 'latitude' => $latitude];
            $i++;
        }

        foreach ($interest_points as $point) {
            $loc = Location::where('latitude', '=', $point['latitude'])->where('longitude', '=', $point['longitude'])->first();
            $interest_point = InterestPoint::where('location_id', '=', $loc->id)->first();
            $trail->interest_points()->save($interest_point);
        }
        return redirect(route('home'))->withOk("Le sentier a bien été créé ! :)");
    }

    public function createLocation($datas)
    {
        //     $input_loc = ['latitude' => $datas->latitude, 'longitude' => $datas->longitude];
        //     $loc = Location::create($input_loc);
        //     return $loc->id;
        return false;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $trail = Trail::findOrFail($id);
        return Inertia::render('Trail/TrailIndex', ['trail' => $trail]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $trail = Trail::findOrFail($id);
        return Inertia::render('Trail/TrailIndex', ['trails' => $trail]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $trail = Trail::findOrFail($id);
        $new_Inputs = $request->except('location_start', 'location_end', 'location_parking', 'interest_points');
        $new_Inputs['time'] = TrailController::getTimeTrail($request->interest_points);

        // Gestions des Foreign Key depuis la Request
        $loc_start_id = Location::where('latitude', '=', $request->location_start->latitude)->where('longitude', '=', $request->location_start->longitude)->id;
        $loc_end_id = Location::where('latitude', '=', $request->location_end->latitude)->where('longitude', '=', $request->location_end->longitude)->id;
        $loc_parking_id = Location::where('latitude', '=', $request->location_parking->latitude)->where('longitude', '=', $request->location_parking->longitude)->id;
        $img_id = Img::where('img', '=', $request->img)->id;
        $interest_points = $request->interest_points;


        // FOREIGN KEY - interest_point
        foreach ($interest_points as $point) {
            $id_point = InterestPoint::where('latitude', '=', $point->latitude)->where('longitude', '=', $point->longitude);
            if (!$trail->interest_points()->whereHas($id_point))
            // si un point d'interet dans la requete n'est pas relié au sentier
            {
                $trail->interest_points()->save($id_point);
            }
        }
        // \/ Tout regrouper dans un énorme forEach avec les variables créer dynamiquement ???????????????????

        // FOREIGN KEY - location_start
        // Si le retour de la Location est idem à celle stocker sur le sentier
        if ($trail->location_start_id !== $loc_start_id) /*{
            $new_Inputs['location_start_id'] = $loc_start_id; ----> si ça marche pas !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
        } else*/ {
            $trail->location_start()->delete();

            // Création de la nouvelle Location + lien avec le trail
            $input_loc = ['longitude' => $request->location_start->longitude, 'latitude' => $request->location_start->latitude];
            $loc = Location::create($input_loc);
            $trail->location_start()->save($loc);
        }


        // FOREIGN KEY - location_end
        // Si le retour de la Location est idem à celle stocker sur le sentier
        if ($trail->location_end_id !== $loc_end_id) {
            $trail->location_end()->delete();

            // Création de la nouvelle Location + lien avec le trail
            $input_loc = ['longitude' => $request->location_end->longitude, 'latitude' => $request->location_end->latitude];
            $loc = Location::create($input_loc);
            $trail->location_end()->save($loc);
        }


        // FOREIGN KEY - location_parking
        // Si le retour de la Location est idem à celle stocker sur le sentier
        if ($trail->location_parking_id !== $loc_parking_id) {
            $trail->location_parking()->delete();

            // Création de la nouvelle Location + lien avec le trail
            $input_loc = ['longitude' => $request->location_parking->longitude, 'latitude' => $request->location_parking->latitude];
            $loc = Location::create($input_loc);
            $trail->location_parking()->save($loc);
        }

        // FOREIGN KEY - img
        if ($trail->img_id !== $img_id) {
            $trail->img()->delete();

            // Création de la nouvelle Img + lien avec le trail
            $img = Img::create($request->img);
            $trail->img()->save($img);
        }


        $trail->update($new_Inputs);
        return redirect(route('home'))->withOk("Le sentier a bien été modifié ! :)");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // vérifier l'authentification du usr !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
        Trail::findOrFail($id)->delete();
        return redirect(route('home'));
    }
}
