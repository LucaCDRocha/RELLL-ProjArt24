<?php

namespace App\Http\Controllers;

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
        return Inertia::render('InterestPoint/InterestPointCreate');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Creation New InterestPoint
        $IP_inputs = $request->except('location', 'tag');
        $interestPoint = InterestPoint::create($IP_inputs);

        // FOREIGN KEY - Tag
        $tag = Tag::where('name', $request->tag);
        $interestPoint->tag()->save($tag);

        // FOREIGN KEY - Location
        $input_loc = ['latitude' => $request->location->latitude, 'longitude' => $request->location->longitude];
        $loc = Location::create($input_loc);
        $interestPoint->location()->save($loc);
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
        return Inertia::render('InterestPoint/InterestPointEdit')->with(InterestPoint::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $interest_point = InterestPoint::findOrFail($id);
        $new_inputs = $request->except('location', 'tag');


        // FOREIGN KEY - Tag
        $tag = Tag::where('name', $request->tag)->id;
        if (!$tag->id == $interest_point->tag_id) {
            $interest_point->tag()->detach();
            $interest_point->tag()->save($tag);
        }

        // FOREIGN KEY - Location
        $loc = Location::where('latitude', $request->location->latitude)->where('longitude', $request->location->longitude);
        if (is_null($loc)) {
            $loc = Location::create(['latitude' => $request->location->latitude, 'longitude' => $request->location->longitude]);
            $interest_point->location()->delete();
            $interest_point->location()->save($loc);
        }

        $interest_point->update($new_inputs);
        return redirect(route('home'))->withOk("Le point d'intérêts a bien été modifié :)");
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
