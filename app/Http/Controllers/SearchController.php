<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Trail;
use App\Models\InterestPoint;
use App\Models\Tag;

class SearchController extends Controller
{
    public function search()
    {
        $trails = Trail::all()
            ->load('img')
            ->select('img', 'name', 'id', 'difficulty');

        $interestPoints = InterestPoint::all()
            ->load('imgs', 'tags')
            ->select('imgs', 'name', 'id', 'tags');

        $tags = Tag::all()
            ->select('name', 'id');

        // combine themes and tags into one array
        $filters = [];
        foreach ($tags as $tag) {
            $filters[] = ['name' => $tag['name'], 'selected' => false];
        }

        $difficulties = [
            ['name' => 'Facile', 'selected' => false],
            ['name' => 'Moyen', 'selected' => false],
            ['name' => 'Difficile', 'selected' => false],
        ];

        return Inertia::render('Search', ['trails' => $trails, 'interestPoints' => $interestPoints, 'filters' => $filters, 'difficulties' => $difficulties]);
    }
}