<?php

namespace App\Http\Controllers;

use App\Models\Historic;
use App\Models\Trail;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HistoricsController extends Controller
{
    public function showHistorics(){
        $historics = Historic::where('user_id', auth()->id())->with('trail')->get();
        $trailData = $historics->map(function($historic) {
            return $historic->trail->load('img');
        });

        foreach ($trailData as $trail) {
            switch ($trail->difficulty) {
                case 1:
                    $trail->difficulty = "Facile";
                    break;
                case 2:
                    $trail->difficulty = "Moyen";
                    break;
                case 3:
                    $trail->difficulty = "Difficile";
                    break;
            }
        }

        $myTrails = Trail::where('user_id', auth()->id())->get()->load('img');
        
        foreach ($myTrails as $trail) {
            switch ($trail->difficulty) {
                case 1:
                    $trail->difficulty = "Facile";
                    break;
                case 2:
                    $trail->difficulty = "Moyen";
                    break;
                case 3:
                    $trail->difficulty = "Difficile";
                    break;
            }
        }
        
        return Inertia::render('History', ['historics' => $trailData, 'myTrails' => $myTrails]);
    }
}
