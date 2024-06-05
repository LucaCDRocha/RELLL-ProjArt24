<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Trail;
use App\Models\InterestPoint;

class HomeController extends Controller
{
    public function home()
    {
        $allTrails = Trail::all()->load('img')->select('difficulty', 'img', 'id', 'name', 'time');

        $allInterestPoints = InterestPoint::all()->load('imgs')->select('imgs', 'name', 'id');
        return Inertia::render('Home', ['trails' => $allTrails, 'interestPoints' => $allInterestPoints]);
    }
}
