<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');
    
        $posts = \App\Models\Post::where('body', 'like', '%' . $query . '%')
            // ->orWhere( 'like', '%' . $query . '%')
            ->latest()
            ->paginate(10); // Paginate results
    
        return view('search', compact('posts', 'query'));
    }

    public function show($id)
{
    $post = Post::findOrFail($id); // Fetch the post or throw a 404 error if not found
    return view('search.show', compact('post'));
}
}
