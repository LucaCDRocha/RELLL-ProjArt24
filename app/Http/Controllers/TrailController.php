<?php

namespace App\Http\Controllers;

use App\Http\Requests\TrailCreateRequest;
use App\Http\Requests\TrailUpdateRequest;
use App\Models\Img;
use App\Models\InterestPoint;
use App\Models\Location;
use App\Models\Trail;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Tag;

use function PHPUnit\Framework\isNull;

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
                'is_accessible' => $request->is_accessible == 'Oui' ? 1 : 0,
                'info_transport' => $request->info_transport,
                'user_id' => $request->user_id,
                'img_id' => $img_id,
                'location_start_id' => $loc_start_id,
                'location_end_id' => $loc_end_id,
                // 'location_parking_id' => $loc_parking_id ? $loc_parking_id : 0,
            ];
        if ($loc_parking_id) {
            $inputs['location_parking_id'] = $loc_parking_id;
        }

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

        return Inertia::render('Trail/SuccessTrailCreate');
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
        $trail = Trail::findOrFail($id)->load('img', 'location_start', 'location_end', 'location_parking', 'interest_points', 'rankings', 'user', 'comments');
        foreach ($trail->comments as $comment) {
            $comment->load('user', 'likes');

            $comment->user->makeHidden('email', 'email_verified_at', 'password', 'remember_token', 'created_at', 'updated_at', 'is_admin');
        }

        $reactions = [];
        foreach ($trail->rankings as $ranking) {
            $ranking->load('user');
            $comment = $trail->comments()->where('user_id', $ranking->user_id)->where('created_at', $ranking->created_at)->exists() ? $trail->comments()->where('user_id', $ranking->user_id)->where('created_at', $ranking->created_at)->first() : null;
            $reaction = [
                'user' => $ranking->user,
                'ranking' => $ranking,
                'comment' => $comment,
            ];

            if ($reaction['comment'] !== null) {
                $reaction['comment']->load('likes');
            }

            $reactions[] = $reaction;

            $ranking->user->makeHidden('email', 'email_verified_at', 'password', 'remember_token', 'created_at', 'updated_at', 'is_admin');
        }

        // order the reactions by likes
        // dd($reactions);
        usort($reactions, function ($a, $b) {
            if ($a['comment'] === null) {
                return 1;
            } else if ($b['comment'] === null) {
                return -1;
            } else {
                return count($b['comment']->likes) <=> count($a['comment']->likes);
            }
        });

        $trail['reactions'] = $reactions;

        $trail->user->makeHidden('email', 'email_verified_at', 'password', 'remember_token', 'created_at', 'updated_at', 'is_admin');

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
        $trail = Trail::findOrFail($id)->load('img', 'location_start', 'location_end', 'location_parking', 'interest_points');

        $interest_points = InterestPoint::all()->load('imgs', 'tags', 'location');

        foreach ($trail->interest_points as $interest_point) {
            $interest_point->load('location');
        }

        return Inertia::render('Trail/TrailEdit', ['trail' => $trail, 'interestPoints' => $interest_points]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // $trail = Trail::findOrFail($id);
        // $new_Inputs = $request->except('location_start', 'location_end', 'location_parking', 'interest_points');
        // $new_Inputs['time'] = TrailController::getTimeTrail($request->interest_points);

        // // Gestions des Foreign Key depuis la Request
        // $loc_start_id = Location::where('latitude', '=', $request->location_start->latitude)->where('longitude', '=', $request->location_start->longitude)->id;
        // $loc_end_id = Location::where('latitude', '=', $request->location_end->latitude)->where('longitude', '=', $request->location_end->longitude)->id;
        // $loc_parking_id = Location::where('latitude', '=', $request->location_parking->latitude)->where('longitude', '=', $request->location_parking->longitude)->id;
        // $img_id = Img::where('img', '=', $request->img)->id;
        // $interest_points = $request->interest_points;


        // // FOREIGN KEY - interest_point
        // foreach ($interest_points as $point) {
        //     $id_point = InterestPoint::where('latitude', '=', $point->latitude)->where('longitude', '=', $point->longitude);
        //     if (!$trail->interest_points()->whereHas($id_point))
        //     // si un point d'interet dans la requete n'est pas relié au sentier
        //     {
        //         $trail->interest_points()->save($id_point);
        //     }
        // }
        // // \/ Tout regrouper dans un énorme forEach avec les variables créer dynamiquement ???????????????????

        // // FOREIGN KEY - location_start
        // // Si le retour de la Location est idem à celle stocker sur le sentier
        // if ($trail->location_start_id !== $loc_start_id) /*{
        //     $new_Inputs['location_start_id'] = $loc_start_id; ----> si ça marche pas !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
        // } else*/ {
        //     $trail->location_start()->delete();

        //     // Création de la nouvelle Location + lien avec le trail
        //     $input_loc = ['longitude' => $request->location_start->longitude, 'latitude' => $request->location_start->latitude];
        //     $loc = Location::create($input_loc);
        //     $trail->location_start()->save($loc);
        // }


        // // FOREIGN KEY - location_end
        // // Si le retour de la Location est idem à celle stocker sur le sentier
        // if ($trail->location_end_id !== $loc_end_id) {
        //     $trail->location_end()->delete();

        //     // Création de la nouvelle Location + lien avec le trail
        //     $input_loc = ['longitude' => $request->location_end->longitude, 'latitude' => $request->location_end->latitude];
        //     $loc = Location::create($input_loc);
        //     $trail->location_end()->save($loc);
        // }


        // // FOREIGN KEY - location_parking
        // // Si le retour de la Location est idem à celle stocker sur le sentier
        // if ($trail->location_parking_id !== $loc_parking_id) {
        //     $trail->location_parking()->delete();

        //     // Création de la nouvelle Location + lien avec le trail
        //     $input_loc = ['longitude' => $request->location_parking->longitude, 'latitude' => $request->location_parking->latitude];
        //     $loc = Location::create($input_loc);
        //     $trail->location_parking()->save($loc);
        // }

        // // FOREIGN KEY - img
        // if ($trail->img_id !== $img_id) {
        //     $trail->img()->delete();

        //     // Création de la nouvelle Img + lien avec le trail
        //     $img = Img::create($request->img);
        //     $trail->img()->save($img);
        // }
        // V2.0
        $trail = Trail::findOrFail($id);

        // Supprime l'ancienne photo et modofie la FK dans trail
        if ($request->img) {
            ImgController::updateImgTrail($request->img, $trail->id);
        }
        /* 
            Sauvegarde d'un trail dans la BD
        */

        // Sauvegarde des coordonées GPS
        $loc_start = Location::findOrFail($trail->location_start_id);

        if (
            $loc_start->latitude != $request->location_start['latLng']['lat'] ||
            $loc_start->longitude != $request->location_start['latLng']['lng']
        ) {
            $newLoc = LocationController::createLocation($request->location_start);
            $new_inputs['location_start_id'] = $newLoc;
        }

        if ($trail->location_parking_id || $request->location_parking) {
            $loc_parking = Location::findOrFail($trail->location_parking_id);
            if (
                $loc_parking->latitude != $request->location_parking['latLng']['lat'] ||
                $loc_parking->longitude != $request->location_parking['latLng']['lng']
            ) {
                $newLoc = LocationController::createLocation($request->location_parking);
                $new_inputs['location_parking_id'] = $newLoc;
            }
        }

        $loc_end = Location::findOrFail($trail->location_end_id);
        if (
            $loc_end->latitude != $request->location_end['latLng']['lat'] ||
            $loc_end->longitude != $request->location_end['latLng']['lng']
        ) {
            $newLoc = LocationController::createLocation($request->location_end);
            $new_inputs['location_end_id'] = $newLoc;
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

        $new_inputs =
            [
                'name' => $request->name,
                'time' => TrailController::getTimeTrail($request->time),
                'description' => $request->description,
                'difficulty' => $difficulty,
                'is_accessible' => $request->is_accessible == 'Oui' ? 0 : 1,
                'info_transport' => $request->info_transport,
                'user_id' => $request->user_id,
            ];


        /*
        Gestion des points d'interets via la table pivot 
        */
        $trail->interest_points()->detach();
        $interest_points = $request->interest_points;

        foreach ($interest_points as $point) {
            $interest_point = InterestPoint::findOrFail($point['id']);
            $trail->interest_points()->save($interest_point);
        }

        $trail->update($new_inputs);
        return redirect(route('home'))->withOk("Le sentier a bien été modifié ! :)");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $trail = Trail::findOrFail($id)->load('img', 'comments');

        $trail->favorites()->detach();
        $trail->historics()->delete();

        $trail->rankings()->delete();
        foreach ($trail->comments as $comment) {
            $comment->likes()->delete();
            $comment->delete();
        }

        $trail->interest_points()->detach();

        if (file_exists(public_path($trail->img->img_path))) {
            unlink(public_path($trail->img->img_path));
        }
        $trail->delete();
        // Suppression des images en cascade
        $trail->img()->delete();

        return redirect()->route('home');
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
