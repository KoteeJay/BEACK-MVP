<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class FacebookController extends Controller
{
   public function redirect()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function callback()
    {
        try {
            $facebookUser = Socialite::driver('facebook')->user();

            // Check if user already exists
            $user = User::where('email', $facebookUser->getEmail())->first();

            if (!$user) {
                // Create new user
                $user = User::create([
                    'name' => $facebookUser->getName(),
                    'email' => $facebookUser->getEmail(),
                    'facebook_id' => $facebookUser->getId(),
                    'password' => Hash::make(uniqid()), // Random password
                    'email_verified_at' => now(), // Mark as verified since Facebook verified it
                ]);
            } else {
                // Update existing user with Facebook ID if not set
                if (empty($user->facebook_id)) {
                    $user->update([
                        'facebook_id' => $facebookUser->getId(),
                    ]);
                }
            }

            // Log in the user
            Auth::login($user, true); // "true" for "remember me"

            return redirect()->intended('/'); // Redirect to intended page

        } catch (Exception $e) {
            // \Log::error('Facebook authentication failed: ' . $e->getMessage());
            
            return redirect('/login')
                ->with('error', 'Facebook authentication failed. Please try again.');
        }
    }
}
