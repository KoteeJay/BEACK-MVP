<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserManagementController extends Controller
{
    public function index()
    {
        // Exclude current super admin optionally
        $users = User::where('id', '!=', auth()->id())->get();
        return view('admin.dashboard', compact('users'));
    }

    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:user,admin,super_admin',
        ]);

        $user->update(['role' => $request->input('role')]);

        return back()->with('success', "{$user->name}'s role updated to {$user->role}");
    }
}
