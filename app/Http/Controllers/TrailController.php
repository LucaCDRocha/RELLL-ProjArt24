<?php

namespace App\Http\Controllers;

use App\Http\Requests\TrailCreateRequest;
use App\Models\Img;
use App\Models\Location;
use App\Models\Trail;
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

        return Inertia::render('Trail/Trail_index', ['trails' => $allTrails]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Trail/Trail_create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TrailCreateRequest $request)
    {

        // Sauvegarde d'une image dans la BD
        $imgInput = ['img' => $request->img];

        $img = Img::create($imgInput);

        // Sauvegarde d'un trail dans la BD
        $trailInputs = $request->except('img', 'user_id', 'location_start', 'location_end', 'location_parking');
        // effectue le lien entre le trail et l'image
        $trail = Trail::create($trailInputs);
        $trail->img()->save($img);

        // Sauvegarde des coordonées GPS + lien au Trail
        $input_loc_start = ['latitude' => $request->location_start->latitude, 'longitude' => $request->location_start->longitude];
        $loc_start = Location::create($input_loc_start);
        $trail->location_start()->save($loc_start);

        $input_loc_end = ['latitude' => $request->location_end->latitude, 'longitude' => $request->location_end->longitude];
        $loc_end = Location::create($input_loc_end);
        $trail->location_end()->save($loc_end);

        $input_loc_parking = ['latitude' => $request->location_parking->latitude, 'longitude' => $request->location_parking->longitude];
        $loc_parking = Location::create($input_loc_parking);
        $trail->location_parking()->save($loc_parking);

        return redirect(route('home'))->withOk("Le sentier a bien été créé ! :)");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $trail = Trail::findOrFail($id);
        return Inertia::render('InterestPoint/InterestPoint_create')->with($trail); // à voir ce que ça retourne 
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Trail::findOrFail($id)->delete();
        return redirect(route('home'));
    }
}
