<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index()
    {
        return view('dashboard');
    }
    public function create()
    {
        return view('dashboard.create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'body' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        
        $slug = Str::slug($request->body); // Generate slug from body
        $shortSlug = Str::limit($slug, 50, ''); // Shorten the slug

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
        }
        
        Post::create([
            'body' => $request->body,
            'image' => $imagePath,
            'user_id' => Auth::id(),
            'slug' => $shortSlug,
            'published_at' => now(),
        ]);

        return redirect()->route('dashboard')->with('success', 'Post created successfully!');

    
    }
    public function show(Post $post)
    {
        return view('show', [
            'Posts' => $post->id,
        ]);
    }
    
    public function edit(Post $post)
    {
        return view('dashboard.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $request->validate([
            'body' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $post->body = $request->body;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
            $post->image = $imagePath;
        }

        $post->save();

        return redirect()->route('dashboard')->with('success', 'Post updated successfully!');
    }
    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('dashboard')->with('success', 'Post deleted successfully.');
    }

}
