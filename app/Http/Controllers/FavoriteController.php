<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Inertia\Inertia;
use App\Models\Favorite;

class FavoriteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
            $userLists = Favorite::where('user_id', auth()->id())
            ->withCount('trails')    
            ->get();
            return Inertia::render('Favorite/List', ['list' => $userLists]);
    }

    public function allLists(Request $request){
            $name = $request->name;
            $trailId = $request->trailId;
        
            // Récupérer les favoris de l'utilisateur avec les trails associés
            $allLists = Favorite::where('user_id', auth()->id())
                ->with('trails:id') // Charger les trails avec uniquement leur id
                ->get();
        
            // Transformer la collection pour inclure les trail_id
            $allLists = $allLists->map(function($favorite) {
                return [
                    'id' => $favorite->id,
                    'name' => $favorite->name,
                    'trail_ids' => $favorite->trails->pluck('id') // Récupérer les trail_id
                ];
            });

            $currentLists = Favorite::where('user_id', auth()->id())
            ->whereHas('trails', function ($query) use ($trailId) {
                $query->where('trail_id', $trailId);
            })
            ->pluck('id')
            ->toArray();
        
            return Inertia::render('Favorite/MyLists', [
                'allLists' => $allLists, 'title' => $name, 'trailId' => $trailId, 'listIds' => $currentLists
            ]);
        
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Favorite/NewList');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $exists = Favorite::where('user_id', Auth::id())
                          ->where('name', $request->name)
                          ->exists();

        if ($exists) {
            // Si la liste existe déjà, retourner une erreur
            return back()->withErrors(['name' => 'Vous avez déjà une liste avec ce nom.']);
        }

        // Si la liste n'existe pas, créer une nouvelle liste
        $favorite = new Favorite();
        $favorite->name = $request->name;
        $favorite->user_id = Auth::id();
        $favorite->save();

        // Rediriger avec un message de succès
        return redirect()->route('bookmark.index')->with('success', 'Liste créée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $favorite = Favorite::findOrFail($id);
        $trails = $favorite->trails()->get()->load('img');
        return Inertia::render('Favorite/OneList', ['listDetails' => $favorite, 'trailsList' => $trails]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $favorite = Favorite::findOrFail($id);
        $trails = $favorite->trails()->get()->load('img');
        return Inertia::render('Favorite/EditList', ['listDetails' => $favorite, 'trailsList' => $trails]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $favorite = Favorite::findOrFail($id);
        foreach ($request['aSupprimer'] as $listASupprimer) {
            dump($listASupprimer);
            $favorite->trails()->detach($listASupprimer);
        }

        return $this->index();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function addTrail(Request $request){
        $userId = auth()->id();
    $newCheckIds = $request['check_ids'];
    $trailId = $request['trail_id'];

        foreach($newCheckIds as $list) {
            $thelist = Favorite::findOrFail($list);

            $exists = $thelist->trails()->where('trail_id', $trailId)->exists();

            // Si la relation n'existe pas, l'ajouter
            if (!$exists) {
                $thelist->trails()->attach($request['trail_id']);
            }
        }

        $currentCheckIds = Favorite::where('user_id', $userId)
        ->whereHas('trails', function ($query) use ($trailId) {
            $query->where('trail_id', $trailId);
        })
        ->pluck('id')
        ->toArray();

        // Identifier les relations à supprimer
    $toDetach = array_diff($currentCheckIds, $newCheckIds);

    // Supprimer les relations qui n'existent plus
    foreach ($toDetach as $list) {
        $tag = Favorite::findOrFail($list);
        $tag->trails()->detach($trailId);
    }

        return $this->index();
    }
}
