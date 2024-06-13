<?php

namespace App\Http\Controllers;

use App\Models\Img;
use App\Models\InterestPoint;
use App\Models\Location;
use App\Models\Tag;
use Inertia\Inertia;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\ImgController;
use App\Http\Requests\InterestPointCreateRequest;
use App\Http\Requests\InterestPointUpdateRequest;

class InterestPointController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('InterestPoint/InterestPoint')->with(InterestPoint::all());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('InterestPoint/InterestPointCreate', ['tags' => Tag::all()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(InterestPointCreateRequest $request)
    {
        $id_loc = LocationController::createLocation($request->location);

        $seasons = $request->seasons;
        if (sizeof($seasons) == 4) {
            $seasons = "toutes";
        } else {
            $seasons = "";
            foreach ($request->seasons as $season) {
                $seasons .= $season['name'] . ', ';
            }
            $seasons = substr($seasons, 0, -2);
        }

        // Creation New InterestPoint
        $IP_inputs = [
            'name' => $request->name,
            'description' => $request->description,
            'url' => $request->url ? $request->url : '-',
            'open_seasons' => $seasons,
            'location_id' => $id_loc,

        ];
        $interestPoint = InterestPoint::create($IP_inputs);

        $tags = $request->tags;
        foreach ($tags as $tag) {
            $tagDB = Tag::where('name', $tag['name'])->first();
            $interestPoint->tags()->attach($tagDB->id);
        }
        // Gestion des images
        foreach ($request->imgs as $picture) {
            // Si l'image est corrompu, le point d'interet n'est finalement pas crée
            if (!ImgController::storeImgInterestPoint($picture, $interestPoint->id)) {
                $interestPoint->tags()->detach();
                $interestPoint->delete();
            };
        }
      
        return Inertia::render('InterestPoint/SuccessInterestPointCreate');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Inertia::render('InterestPoint/InterestPointShow')->with('interestPoint', $this->getInterestPoint($id));
    }

    /**
     * Return the InterestPoint with the id in JSON format
     * 
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function showJson(string $id)
    {
        return $this->getInterestPoint($id);
    }

    /**
     * Get the InterestPoint with the id
     * 
     * @param string $id
     * @return \App\Models\InterestPoint
     */
    public function getInterestPoint(string $id)
    {
        $interestPoint = InterestPoint::findOrFail($id)->load('location', 'tags', 'imgs', 'trails');
        foreach ($interestPoint->trails as $trail) {
            $trail->load('img');
        }

        return $interestPoint;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $IP = InterestPoint::findOrFail($id)->load('imgs', 'tags', 'location');
        $loc = Location::findOrFail($IP->location_id);
        $imgs = Img::where('interest_point_id', '=', $id)->get();
        return Inertia::render('InterestPoint/InterestPointEdit', [
            'interest_point' => $IP, 'tags' => Tag::all(), 'imgs' => $imgs,
            'location' => ['latitude' => $loc->latitude, 'longitude' => $loc->longitude]
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(InterestPointUpdateRequest $request, string $id)
    {
        $interestPoint = InterestPoint::findOrFail($id);

        $loc_id = LocationController::tryIdLocationOrNew($id, $request->location);

        $old_seasons = [];
        foreach ($request->seasons as $season) {
            array_push($old_seasons, $season['name']);
        }

        $seasons = sizeof($old_seasons) != 4 ? implode(',', $old_seasons) : "Toutes";

        // Creation New InterestPoint
        $IP_inputs = [
            'name' => $request->name,
            'description' => $request->description,
            'url' => $request->url,
            'open_seasons' => $seasons,
            'location_id' => $loc_id,
        ];

        $interestPoint->tags()->detach();
        foreach ($request->tags as $tag) {
            $tag = Tag::findOrFail($tag['id']);
            $interestPoint->tags()->attach($tag);
        }


        if (sizeof($request->imgs) > 0) {
            if (!ImgController::updateImgsInterestPoints($request->imgs, $id)) {
                return Inertia::render("Une des images que vous avez uploadé n'est pas valide");
            };
        }
        $interestPoint->update($IP_inputs);

        return redirect()->route('home');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $interestPoint = InterestPoint::findOrFail($id)->load('trails', 'tags', 'imgs');


        foreach ($interestPoint->tags as $tag) {
            $interestPoint->tags()->detach($tag->id);
        }

        foreach ($interestPoint->imgs as $img) {
            if (file_exists(public_path($img->img_path))) {
                unlink(public_path($img->img_path));
            }
            $img->delete();
        }


        foreach ($interestPoint->trails as $trail) {
            $trail->interest_points()->detach($interestPoint->id);
            if (sizeof($trail->interest_points) == 0) {
                $trail->load('img');

                $trail->favorites()->detach();
                $trail->historics()->delete();

                $trail->rankings()->delete();
                $trail->comments()->delete();

                if (file_exists(public_path($trail->img->img_path))) {
                    unlink(public_path($trail->img->img_path));
                }
                $trail->delete();

                $trail->img()->delete();
            }
        }

        $interestPoint->delete();

        return redirect()->route('home');
    }

    /**
     * Display the map page
     * 
     * @return \Inertia\Response
     */
    public function map()
    {
        $allInterestPoints = InterestPoint::all()->load('location', 'imgs', 'tags');

        $tags = Tag::all()
            ->select('name', 'id');

        // combine themes and tags into one array
        $filters = [];
        foreach ($tags as $tag) {
            $filters[] = ['name' => $tag['name'], 'selected' => false];
        }

        return Inertia::render('Map', ['interestPoints' => $allInterestPoints, 'filters' => $filters]);
    }
}
