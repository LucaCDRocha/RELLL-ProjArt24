<?php

namespace App\Http\Controllers;

use App\Models\Like;

class LikeController extends Controller
{
    /**
     * Like or unlike a comment
     * 
     * @param int $comment_id
     * @param int $user_id
     * @return \Illuminate\Http\JsonResponse
     */
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
