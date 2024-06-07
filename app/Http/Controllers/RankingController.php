<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Ranking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

use function PHPUnit\Framework\isNull;

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


    public function create($id)
    {
        return Inertia::render('Interaction/RankTrail', ['trail_id' => $id]);
    }

    public function store(Request $request)
    {
        $inputs = ['note' => $request->rank, 'trail_id' => $request->trail_id, 'user_id' => $request->user()->id];
        if (!isNull($request->comment)) {
            Comment::create(['text' => $request->comment, 'user_id' => $request->user()->id, 'trail_id' => $request->trail_id]);
        }
        Ranking::create($inputs);
        return Inertia::render('Interaction/SuccessRank');
    }

    public static function unRank($id)
    {
        return Ranking::findOrFail($id)->delete();
    }
}
