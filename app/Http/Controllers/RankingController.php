<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Ranking;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RankingController extends Controller
{
    /**
     * Get the average ranking of a trail
     * 
     * @param int $trail_id
     * @return float
     */
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

    /**
     * Display the form for ranking a trail
     * 
     * @param int $id
     * @return \Inertia\Response
     */
    public function create($id)
    {
        return Inertia::render('Interaction/RankTrail', ['trail_id' => $id]);
    }

    /**
     * Store a newly created ranking in database
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Inertia\Response
     */
    public function store(Request $request)
    {
        $inputs = ['note' => $request->rank, 'trail_id' => $request->trail_id, 'user_id' => $request->user()->id];
        if ($request->comment != "") {
            Comment::create(['text' => $request->comment, 'user_id' => $request->user()->id, 'trail_id' => $request->trail_id]);
        }
        Ranking::create($inputs);
        return Inertia::render('Interaction/SuccessRank');
    }

    /**
     * Remove the specified ranking from database
     * 
     * @param int $id
     * @return bool
     */
    public static function unRank($id)
    {
        return Ranking::findOrFail($id)->delete();
    }
}
