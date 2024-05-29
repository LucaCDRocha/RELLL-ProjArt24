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
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $allTags = Tag::all();
        return Inertia::render('InterestPoint/InterestPoint_create', ['tags' => $allTags]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Création du point d'interet dans la BD
        $IP_inputs = $request->except('location', 'tag');
        $interestPoint = InterestPoint::create($IP_inputs);

        // liaison des Foreign Keys
        $tag = Tag::where('name', $request->tag);
        $interestPoint->tag()->save($tag);

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
        return Inertia::render('InterestPoint/InterestPoint_create')->with($interestPoint); // à voir ce que ça retourne 
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
       InterestPoint::findOrFail($id)->delete();
        return redirect(route('home'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
