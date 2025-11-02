<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class LikeButton extends Component
{
    public Post $post;
    public bool $hasLiked;

    public function mount(Post $post)
    {
        $this->post = $post;
        $this->hasLiked = Auth::check() && $post->likedBy()->where('user_id', Auth::id())->exists();
    }
    
    public function toggleLike()
    {
        if (auth()->guest()) {
            return $this->redirect(route('login'), true);
        }

        $user = auth()->user();
        if ($this->hasLiked) {
            $user->likes()->detach($this->post);
            $this->hasLiked = false;
        } else {
            $user->likes()->attach($this->post);
            $this->hasLiked = true;
        }

        // Refresh the post to get the updated likes count
        $this->post->refresh();
    }

    public function render()
    {
        return view('livewire.like-button');
    }
}
    
    
    