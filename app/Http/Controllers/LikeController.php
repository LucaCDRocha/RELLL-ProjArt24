<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    //

    public static function likeOrUnlikeComment(Request $request)
    {
        $user_id = $request->user()->id;
        $like = Like::where('user_id', '=', $user_id)->where('comment_id', '=', $request->comment_id);
        if (is_null($like)) {
            Like::create(['user_id' => $user_id], $request->comment_id);
        } else {
            $like->delete();
        }
        return response()->json(
            [
                'message' => 'success'
            ]
        );
    }
}
