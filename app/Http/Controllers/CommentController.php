<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Store comment
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:1000',
            'blog_post_id' => 'required|exists:blog_posts,id',
        ]);

        Comment::create([
            'content' => $validated['content'],
            'blog_post_id' => $validated['blog_post_id'],
            'user_id' => Auth::id(),
        ]);

        return back()->with('status', 'Comment posted!');
    }

    /**
     * Delete comment
     */
    public function destroy(Comment $comment)
    {
        if (Auth::id() !== $comment->user_id && !Auth::user()->isAdmin()) {
            abort(403);
        }

        $comment->delete();
        return back()->with('status', 'Comment deleted!');
    }
}
