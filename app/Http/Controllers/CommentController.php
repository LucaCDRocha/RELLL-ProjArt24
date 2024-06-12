<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Trail;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($idTrail)
    {
        $comments = Comment::paginate(5);
        $links = $comments->render();

        return Inertia::render('', ['comments' => $comments, 'links' => $links]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($trail_id)
    {
        //
        return Inertia::render('InterestPoint/InterestPointCreate', ['trail_id' => $trail_id]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $comment = Comment::create([
            'text' => $request->comment,
            'trail_id' => $request->trail_id,
            'user_id' => $request->user()->id
        ]);
        return;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Inertia::render('', ['comment' => Comment::findOrFail($id)]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $comment = Comment::findOrFail($id);
        $trail = Trail::findOrFail($comment->trail_id);
        $comment->delete();
        return Inertia::render("Trails/Trailshow/$trail->id"); // modifier comme Luca a fait
    }

    public function createComment(Request $request)
    {
        $comment = Comment::create([
            'text' => $request->text,
            'trail_id' => $request->trail_id,
            'user_id' => $request->user()->id
        ]);
        return Inertia::render('Interaction/SuccessRank');
    }
}
