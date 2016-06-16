<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Http\Requests;
use App\Comment;

class CommunitiesController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        $data = \Auth::user();
        $comments = json_decode(Comment::allComments(), true);
        return view('communities', compact('data','comments'));
    }

    public function submitComment(CommentRequest $request) {
        $comment = new Comment;

        $comment->user_id = auth()->user()->id;
        $comment->name = auth()->user()->name;
        $comment->comment_text = $request->comment_text;

        $comment->save();
        session()->flash('message-good', 'Your comment has been posted!');
        return redirect('dashboard/communities');
    }
}