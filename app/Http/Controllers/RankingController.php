<?php

namespace App\Http\Controllers;

use App\Models\Ranking;
use Illuminate\Http\Request;

class RankingController extends Controller
{
    public static function getRanking($trail_id)
    {
        $rankings = Ranking::where('trail_id', '=', $trail_id)->get();
        $allRankings = 0;
        foreach ($rankings as $ranking) {
            $allRankings .= $ranking;
        }
        $avgRanking = floor(($allRankings / sizeof($rankings)) * 2) / 2;
        return $avgRanking;
    }

    public static function rank(Request $request)
    {
        Ranking::create($request->all());
    }

    public static function unRank($id)
    {
        $ranking = Ranking::findOrFail($id)->delete();;
    }
}
