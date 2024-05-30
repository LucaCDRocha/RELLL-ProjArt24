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
    public function store(TrailCreateRequest $request)
    {

        // !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! ATTENTION !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
        // il manque toute la partie pour le tracé du chemin avec les points d'intérets. 

        // Sauvegarde d'une image dans la BD
        $imgInput = ['img' => $request->img];

        $img = Img::create($imgInput);

        // Sauvegarde d'un trail dans la BD
        $trailInputs = $request->except('img', 'user_id', 'location_start', 'location_end', 'location_parking', 'interest_points');
        // effectue le lien entre le trail et l'image et le user
        $trail = Trail::create($trailInputs);
        $trail->img()->save($img);
        $trail->user()->save(User::findOrFail($request->user_id));

        // Sauvegarde du tableau de interest_points et des liens FK
        $interest_points = $request->interest_points;

        foreach ($interest_points as $point) {
            $id_point = InterestPoint::where('latitude', '=', $point->latitude)->where('longitude', '=', $point->longitude);
            $trail->interestPoints()->save($id_point);
        }

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
