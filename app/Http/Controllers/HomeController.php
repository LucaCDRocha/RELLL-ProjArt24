<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Trail;
use App\Models\InterestPoint;
use App\Models\Tag;

class HomeController extends Controller
{
    public function home()
    {
        $allTrails = Trail::all()->load('img', 'rankings');

        foreach ($allTrails as $trail) {
            $trail->note = $trail->rankings()->avg('note');
        }

        $allTrails = $allTrails->sortByDesc('note')->take(7);
        $allTrails = $allTrails->select('difficulty', 'img', 'id', 'name', 'time');
        $allTrails = $allTrails->values();

        $allInterestPoints = InterestPoint::latest()->take(7)->get()->load('imgs')->select('imgs', 'name', 'id');

        $tags = Tag::all();
        return Inertia::render('Home', ['trails' => $allTrails, 'interestPoints' => $allInterestPoints, 'tags' => $tags]);
    }
}
