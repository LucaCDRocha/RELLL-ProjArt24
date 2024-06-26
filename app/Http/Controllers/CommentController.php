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
     * 
     * @param int $idTrail
     * @return \Inertia\Response
     */
    public function index($idTrail)
    {
        $comments = Comment::paginate(5);
        $links = $comments->render();

        return Inertia::render('', ['comments' => $comments, 'links' => $links]);
    }

    /**
     * Show the form for creating a new resource.
     * 
     * @param int $trail_id
     * @return \Inertia\Response
     */
    public function create($trail_id)
    {
        //
        return Inertia::render('InterestPoint/InterestPointCreate', ['trail_id' => $trail_id]);
    }

    /**
     * Store a newly created resource in storage.
     * 
     * @param \Illuminate\Http\Request $request
     * @return void
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
     * 
     * @param string $id
     * @return \Inertia\Response
     */
    public function show(string $id)
    {
        return Inertia::render('', ['comment' => Comment::findOrFail($id)]);
    }

    /**
     * Remove the specified resource from storage.
     * 
     * @param string $id
     * @return \Inertia\Response
     */
    public function destroy(string $id)
    {
        $comment = Comment::findOrFail($id);
        $trail = Trail::findOrFail($comment->trail_id);
        $comment->delete();
        return Inertia::render("Trails/Trailshow/$trail->id"); // modifier comme Luca a fait
    }

    /**
     * Create a comment
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Inertia\Response
     */
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
