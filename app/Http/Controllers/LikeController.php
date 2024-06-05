<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    //

    public static function likeComment($user_id, $comment_id)
    {
        Like::create(['user_id' => $user_id], $comment_id);
    }

    public static function unLikeComment($id)
    {
        Like::findOrFail($id)->delete();
    }
}
