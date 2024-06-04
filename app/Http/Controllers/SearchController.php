<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Trail;
use App\Models\InterestPoint;

class SearchController extends Controller
{
    public function search()
    {
        $trails = Trail::all()
            ->load('img', 'themes')
            ->select('img', 'name', 'id', 'difficulty', 'themes');

        $interestPoints = InterestPoint::all()
            ->load('imgs', 'tag')
            ->select('imgs', 'name', 'id', 'tag');

        return Inertia::render('Search', ['trails' => $trails, 'interestPoints' => $interestPoints]);
    }
}
