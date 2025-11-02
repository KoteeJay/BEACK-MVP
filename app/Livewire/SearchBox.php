<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Component;

class SearchBox extends Component
{
    public $query = ''; // The search query entered by the user
    public $posts = []; // Search results
    public function search()
    {
        // Redirect to the search page with the query as a parameter
        return redirect()->route('search', ['query' => $this->query]);
    }
    public function updatedQuery()
    {
        // Fetch posts matching the query as the user types
        $this->posts = Post::where('body', 'like', '%' . $this->query . '%')
            ->latest()
            ->take(10)
            ->get();
    }
    public function render()
    {
        return view('livewire.search-box');
    }
}
