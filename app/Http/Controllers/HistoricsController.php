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
            return $historic->trail;
        });

        $myTrails = Trail::where('user_id', auth()->id())->get();
        
        return Inertia::render('History', ['historics' => $trailData, 'myTrails' => $myTrails]);
    }
}
