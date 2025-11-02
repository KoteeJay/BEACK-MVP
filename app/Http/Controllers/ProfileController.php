<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Show the user's profile.
     *
     * @return \Illuminate\View\View
     */
    public function show()
    {
        return view('dashboard.profile', [
            'user' => Auth::user(),
        ]);
    }
    /**
     * Update the user's profile.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:1024'],
            'about' => ['nullable', 'string'],
            'company' => ['nullable', 'string', 'max:255'],
            'specialization' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'country' => ['nullable', 'string', 'max:255'],
        ]);

        if ($request->hasFile('photo')) {
            // Delete the old photo if it exists
            if ($user->profile_photo_path) {
                Storage::disk('public')->delete($user->profile_photo_path);
            }

            // Store the new photo
            $path = $request->file('photo')->store('profile-photos', 'public');

            // Update the user's profile photo path
            $user->forceFill([
                'profile_photo_path' => $path,
            ])->save();
        }

        $user->forceFill([
            'name' => $request->name,
            'email' => $request->email,
            'about' => $request->about,
            'company' => $request->company,
            'specialization' => $request->specialization,
            'phone' => $request->phone,
            'country' => $request->country,
        ])->save();

        return redirect()->route('dashboard.profile')->with('success', 'Profile updated successfully.');
    }
}
