<?php

namespace App\Http\Controllers;

use App\Models\Historic;
use App\Models\Trail;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HistoricsController extends Controller
{
    /**
     * Save a trail in the user's historic
     * 
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function save(Request $request){
        if(Historic::where('user_id', auth()->id())->where('trail_id', $request->trail_id)->exists()){
            $historic = Historic::where('user_id', auth()->id())->where('trail_id', $request->trail_id)->first();
            $historic->touch();
        } else{
        $historic = new Historic();
        $historic->user_id = auth()->id();
        $historic->trail_id = $request->trail_id;
        $historic->save();
        }
        return;
    }
}
