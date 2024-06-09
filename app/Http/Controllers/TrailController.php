<?php

namespace App\Http\Controllers;

use App\Http\Requests\TrailCreateRequest;
use App\Models\Img;
use App\Models\InterestPoint;
use App\Models\Location;
use App\Models\Trail;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Tag;

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
        $interestPoints = InterestPoint::all()->load('location', 'imgs', 'tags');
        $filters = Tag::all();
        return Inertia::render('Trail/TrailCreate', ['interestPoints' => $interestPoints, 'filters' => $filters]);
    }

    /**
     * Store a newly created resource in storage.
     */

    public function getTimeTrail($time)
    {
        // transforme le temps ($time qui est en secondes) en time format
        $hours = floor($time / 3600);
        $minutes = floor(($time / 60) % 60);
        $seconds = $time % 60;
        return $hours . ':' . $minutes . ':' . $seconds;
    }

    public function store(TrailCreateRequest $request)
    {
        // Sauvegarde d'une image dans la BD

        // Gestion du nom pour éviter les doublons

        $img_id = ImgController::storeImgTrail($request->img);

        /* 
            Sauvegarde d'un trail dans la BD
        */

        // Sauvegarde des coordonées GPS
        $loc_start_id = LocationController::createLocation($request->location_start);
        $loc_end_id = LocationController::createLocation($request->location_end);
        $loc_parking_id = null;
        if ($request->location_parking !== null) {
            $loc_parking_id = LocationController::createLocation($request->location_parking);
        }

        // changement des valeurs de la difficulté
        $difficulty = '';
        if ($request->difficulty == '1') {
            $difficulty = 'Facile';
        } elseif ($request->difficulty == '2') {
            $difficulty = 'Moyen';
        } else {
            $difficulty = 'Difficile';
        }

        $inputs = // Enlever les default avant lancement de l'app
            [
                'name' => $request->name,
                'time' => TrailController::getTimeTrail($request->time),
                'description' => $request->description,
                'difficulty' => $difficulty,
                'is_accessible' => $request->is_accessible == 'Oui' ? 0 : 1,
                'info_transport' => $request->info_transport,
                'user_id' => $request->user_id,
                'img_id' => $img_id,
                'location_start_id' => $loc_start_id,
                'location_end_id' => $loc_end_id,
                'location_parking_id' => $loc_parking_id ? $loc_parking_id : null,
            ];

        $trail = Trail::create($inputs);

        /*
        Gestion des points d'interets via la table pivot 
        << Actuellement fais avec des strings, À voir si on peut modifier une fois qu'il y aura la carte >>
        */

        // le String doit arriver comme suit Latitude,Longitude;Latitude,Longitude;Latitude,Longitude;...
        $interest_points = $request->interest_points;

        foreach ($interest_points as $point) {
            $interest_point = InterestPoint::findOrFail($point['id']);
            $trail->interest_points()->save($interest_point);
        }
        return redirect()->route('home');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Inertia::render('Trail/TrailShow', ['trail' => $this->getTrail($id)]);
    }

    /**
     * Return the trail with the id in JSON format
     */
    public function showJson(string $id)
    {
        return response()->json($this->getTrail($id));
    }

    /**
     * get the trail with the id
     */
    public function getTrail(string $id)
    {
        $trail = Trail::findOrFail($id)->load('img', 'location_start', 'location_end', 'location_parking', 'interest_points', 'rankings');

        $trail->note = $trail->rankings()->avg('note');

        foreach ($trail->interest_points as $point) {
            $point->load('location', 'tags', 'imgs');
        }

        return $trail;
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

    public function start($id)
    {
        $trail = Trail::findOrFail($id)->load('interest_points', 'location_start', 'location_end', 'location_parking', 'rankings', 'img');
        $trail->note = $trail->rankings()->avg('note');

        foreach ($trail->interest_points as $point) {
            $point->load('location', 'tags', 'imgs');
        }

        return Inertia::render('Trail/TrailStart', ['trail' => $trail]);
    }
}
