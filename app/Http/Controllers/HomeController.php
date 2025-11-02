<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Doctrine\DBAL\Schema\Index;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request){
        // show initial 10 posts
        $posts = Post::latest()->paginate(10);

        return view('index', [
            'Posts' => $posts
        ]);
    }

    // AJAX endpoint to load more posts. Returns JSON with rendered HTML and pagination info.
    public function loadMore(Request $request){
        $page = (int) $request->get('page', 1);

        $posts = Post::latest()->paginate(10, ['*'], 'page', $page);

        $html = '';
        foreach ($posts as $post) {
            $html .= view('components.posts.post-card', ['post' => $post])->render();
        }

        return response()->json([
            'html' => $html,
            'next_page' => $posts->currentPage() < $posts->lastPage() ? $posts->currentPage() + 1 : null,
            'current_page' => $posts->currentPage(),
            'last_page' => $posts->lastPage(),
        ]);
    }

    public function show(Post $post){
        return view('posts.show', [
            'post' => $post
        ]);    
    }
}
