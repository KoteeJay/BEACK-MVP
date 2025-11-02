<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\Attributes\On;

class PostList extends Component
{
    public $search = '';

    #[On('search')]
    public function updateSearch($search)
    {
        $this->search = $search;
        dd('search');
    }
    #[Computed()]
    public function posts()
    {
        return Post::published()
        ->orderBy('Published_at', $this->sort)
        ->where('title', 'like', "%{$this->search}%");
    }
    public function render()
    {
        return view('livewire.post-list');
    }
}
