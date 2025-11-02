<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ProfessionalPostController extends Controller
{
    public function show(User $user)
    {
        // Fetch posts by the professional user
        $posts = $user->posts()->latest()->paginate(20);

        return view('users.posts', compact('user', 'posts'));
    }
}
