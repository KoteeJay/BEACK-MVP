<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserPostController extends Controller
{
     public function show(User $user)
    {
         // Ensure only professional users' posts are displayed
        if ($user->user_type == 'user') {
            return redirect()->route('home.index');
        }

        // Fetch posts by the professional user
        $posts = $user->posts()->latest()->paginate(20);

        return view('admin.prof-post', compact('user', 'posts'));
    }
}
