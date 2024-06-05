<?php

namespace App\Http\Controllers;

use App\Models\Img;
use App\Models\InterestPoint;
use App\Models\Location;
use App\Models\Tag;
use Illuminate\Http\Request;
use Inertia\Inertia;

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
    public function store(Request $request)
    {

        $id_loc = LocationController::createLocation($request->location);
        $seasons = is_array($request->seasons) ? implode(',', $request->seasons) : $request->seasons;

        // Creation New InterestPoint
        $IP_inputs = [
            'name' => $request->name ?: "Test/Erreur",
            'description' => $request->description ?: "Test/erreur",
            'url' => $request->url ?: "Test/Erreur",
            'open_seasons' => $seasons ?: "Test/Erreur",
            'location_id' => $id_loc ?: "1",
            'tag_id' => $request->tag_id ?: "1",

        ];

        $interestPoint = InterestPoint::create($IP_inputs);

        // Gestion des images

        foreach ($request->imgs as $picture) {
            ImgController::storeImgInterestPoint($picture, $interestPoint->id);
        }

        return "Ok";
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $interestPoint = InterestPoint::findOrFail($id);
        return Inertia::render('InterestPoint/InterestPointCreate')->with($interestPoint);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $loc = Location::findOrFail(InterestPoint::findOrFail($id)->location_id);
        $imgs = Img::where('interest_point_id', '=', $id)->get();
        return Inertia::render('InterestPoint/InterestPointEdit', [
            'interest_point' => InterestPoint::findOrFail($id), 'tags' => Tag::all(), 'imgs' => $imgs,
            'location' => ['latitude' => $loc->latitude, 'longitude' => $loc->longitude]
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $interestPoint = InterestPoint::findOrFail($id);


        $loc_id = LocationController::tryIdLocationOrNew($id, $request->location);


        $seasons = is_array($request->seasons) ? implode(',', $request->seasons) : $request->seasons;

        // Creation New InterestPoint
        $IP_inputs = [
            'name' => $request->name,
            'description' => $request->description,
            'url' => $request->url,
            'open_seasons' => $seasons,
            'location_id' => $loc_id,
            'tag_id' => $request->tag_id,

        ];

        if (sizeof($request->imgs) > 0) {
            dd("on rentre");
            ImgController::updateImgsInterestPoints($request->imgs, $id);
        }
        $interestPoint->update($IP_inputs);

        return $request->imgs;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        InterestPoint::findOrFail($id)->delete();
        return Inertia::render("home");
    }
}
