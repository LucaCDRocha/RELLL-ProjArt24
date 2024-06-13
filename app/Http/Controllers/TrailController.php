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
     * Return the time in a time format
     * 
     * @param int $time
     * @return string
     */
    public function getTimeTrail($time)
    {
        // transforme le temps ($time qui est en secondes) en time format
        $hours = floor($time / 3600);
        $minutes = floor(($time / 60) % 60);
        $seconds = $time % 60;
        return $hours . ':' . $minutes . ':' . $seconds;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TrailCreateRequest $request)
    {
        // Sauvegarde d'une image dans la BD
        $img_id = ImgController::storeImgTrail($request->img);

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

        $inputs =
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

        $interest_points = $request->interest_points;

        foreach ($interest_points as $point) {
            $interest_point = InterestPoint::findOrFail($point['id']);
            $trail->interest_points()->save($interest_point);
        }

        return Inertia::render('Trail/SuccessTrailCreate');
    }

    /**
     * Display the specified resource.
     * 
     * @param string $id
     * @return \Inertia\Response
     */
    public function show(string $id)
    {
        return Inertia::render('Trail/TrailShow', ['trail' => $this->getTrail($id)]);
    }

    /**
     * Return the trail with the id in JSON format
     * 
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function showJson(string $id)
    {
        return response()->json($this->getTrail($id));
    }

    /**
     * get the trail with the id
     * 
     * @param string $id
     * @return \App\Models\Trail
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
        $trail = Trail::findOrFail($id);

        // Supprime l'ancienne photo et modofie la FK dans trail
        if ($request->img) {
            ImgController::updateImgTrail($request->img, $trail->id);
        }

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

    /**
     * Show the trail in a map for follow it
     * 
     * @param int $id
     * @return \Inertia\Response
     */
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
