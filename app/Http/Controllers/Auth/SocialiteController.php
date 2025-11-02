<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    /**
     * Redirect the user to the OAuth provider.
     */
    public function redirectToProvider(string $provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from the provider.
     */
    public function handleProviderCallback(string $provider)
    {
        try {
            // Get user information from the provider
            $socialiteUser = Socialite::driver($provider)->user();
        } catch (\Exception $e) {
            // Handle error, e.g., redirect to login with an error message
            return redirect('/login')->withErrors(['social_login' => 'Could not authenticate with ' . ucfirst($provider) . '.']);
        }

        // Find user by provider ID or email
        $user = User::where('provider', $provider)
                    ->where('provider_id', $socialiteUser->getId())
                    ->first();

        // If user doesn't exist, create a new one
        if (!$user) {
            $user = User::updateOrCreate([
                'email' => $socialiteUser->getEmail(),
            ], [
                'name' => $socialiteUser->getName() ?? $socialiteUser->getNickname(),
                'email_verified_at' => now(), // Assume email is verified by provider
                'provider' => $provider,
                'provider_id' => $socialiteUser->getId(),
                'password' => \Illuminate\Support\Str::random(10), // Set a dummy password
            ]);
        }

        // Log the user in
        Auth::login($user, true);

        // Redirect to a dashboard or home page
        return redirect('/home');
    }
}
