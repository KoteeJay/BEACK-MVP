<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Mail\CommentedOnPostMail;
use App\Notifications\PostCommented;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\CommentNotificationMail;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'post_id' => 'required|exists:posts,id',
            'body' => 'required|string',
        ]);

        $comment = Comment::create([
            'post_id' => $request->post_id,
            'user_id' => Auth::id(),
            'body' => $request->body,
        ]);

        // Notify post author
        $postAuthor = $comment->post->user;

        if ($postAuthor && $postAuthor->id !== Auth::id()) {
            $postAuthor->notify(new PostCommented($comment));
        }

        // Notify post author via email
        Mail::to($postAuthor->email)->queue(new CommentNotificationMail($comment));

        return back()->with('success', 'Comment added successfully!');
    }
}
