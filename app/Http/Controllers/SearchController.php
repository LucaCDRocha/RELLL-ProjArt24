<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Trail;
use App\Models\InterestPoint;
use App\Models\Tag;

class SearchController extends Controller
{
    /**
     * Display the search page.
     * 
     * @param int $tag_id
     * @return \Inertia\Response
     */
    public function search(int $tag_id = null)
    {
        $trails = Trail::all()
            ->load('img','interest_points')
            ->select('img', 'name', 'id', 'difficulty', 'time', 'interest_points');
        $allTrails = [];
        foreach ($trails as $trail) {
            $trail['interest_points'] = $trail['interest_points']->pluck('tags');
            $tags = [];
            foreach ($trail['interest_points'] as $tag) {
                $tag = $tag->pluck('name');
                $tags[] = $tag;
            }
            $trail['interest_points'] = $tags;
            $allTrails[] = $trail;
        }

        $interestPoints = InterestPoint::all()
            ->load('imgs', 'tags')
            ->select('imgs', 'name', 'id', 'tags');

        $tags = Tag::all()
            ->select('name', 'id');

        // combine tags into an array
        $filters = [];
        foreach ($tags as $tag) {
            if ($tag['id'] == $tag_id) {
                $filters[] = ['name' => $tag['name'], 'selected' => true];
            } else
            $filters[] = ['name' => $tag['name'], 'selected' => false];
        }

        $difficulties = [
            ['name' => 'Facile', 'selected' => false],
            ['name' => 'Moyen', 'selected' => false],
            ['name' => 'Difficile', 'selected' => false],
        ];

        return Inertia::render('Search', ['trails' => $allTrails, 'interestPoints' => $interestPoints, 'filters' => $filters, 'difficulties' => $difficulties]);
    }
}
