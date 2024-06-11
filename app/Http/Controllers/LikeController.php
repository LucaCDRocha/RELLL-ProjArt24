<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    //

    public static function likeOrUnlikeComment(int $comment_id, int $user_id)
    {
        $like = Like::all()->where('comment_id', '=', $comment_id)->where('user_id', '=', $user_id)->first();
        if (is_null($like)) {
            Like::create(['user_id' => $user_id, 'comment_id' => $comment_id]);
        } else {
            $like->delete();
        }

        $likes = Like::all()->where('comment_id', '=', $comment_id)->count();
        return response()->json([
            'likes' => $likes,
            'user_id' => $user_id,
            'comment_id' => $comment_id,
        ]);
    }
}
