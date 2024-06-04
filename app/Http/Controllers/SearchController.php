<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Trail;
use App\Models\InterestPoint;
use App\Models\Tag;
use App\Models\Theme;

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

        $themes = Theme::all()
            ->select('name', 'id');

        $tags = Tag::all()
            ->select('name', 'id');

        // combine themes and tags into one array
        $filters = [];
        foreach ($themes as $theme) {
            $filters[] = ['name' => $theme['name'], 'selected' => false];
        }
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
