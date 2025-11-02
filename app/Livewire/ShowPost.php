<?php

namespace App\Livewire;

use App\Models\Post;
use App\Models\Comment;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class ShowPost extends Component
{
    public Post $post;
    public $newComment;
    public function mount($postId)
    {
        $this->post = Post::with('comments.user')->findOrFail($postId);
    }

    public function addComment()
    {
        $this->validate([
            'newComment' => 'required|string',
        ]);

        Comment::create([
            'post_id' => $this->post->id,
            'user_id' => Auth::id(),
            'body' => $this->newComment,
        ]);

        $this->newComment = '';
        $this->post->refresh();
    }

    public function render()
    {
        return view('livewire.show-post');
    }
}
