<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->user_type === 'user') {
            return redirect()->route('home.index'); // Redirect regular users to the home page
        }

        // return view('dashboard', [
        //     'posts' => auth()->user()->posts()->latest()->take(10)->get()
        // ]);

        $posts = auth()->user()->posts()->latest()->take(10)->get();

        return view('dashboard', compact('posts'));

    }

}
