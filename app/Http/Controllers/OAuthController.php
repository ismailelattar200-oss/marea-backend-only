<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class OAuthController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->stateless()->redirect();
    }

    /**
     * Obtain the user information from Google.
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
            
            // Find user by email or create new
            $user = User::where('email', $googleUser->getEmail())->first();
            
            if (!$user) {
                // User doesn't exist, create a new one
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    // Generate a random password since they logged in via OAuth
                    'password' => Hash::make(Str::random(16)),
                    'role' => 'customer',
                    'avatar' => $googleUser->getAvatar(),
                ]);
            } else if (!$user->avatar) {
                // If user exists but has no avatar, sync it
                $user->avatar = $googleUser->getAvatar();
                $user->save();
            }

            // Create Sanctum token
            $token = $user->createToken('auth_token')->plainTextToken;

            // Redirect back to frontend with token
            $frontendUrl = env('FRONTEND_URL', 'http://localhost:5173');
            return redirect()->away($frontendUrl . '/auth/callback?token=' . urlencode($token));

        } catch (\Exception $e) {
            Log::error('Google OAuth Error: ' . $e->getMessage());
            $frontendUrl = env('FRONTEND_URL', 'http://localhost:5173');
            return redirect()->away($frontendUrl . '/login?message=' . urlencode('Erreur lors de la connexion avec Google.'));
        }
    }
}
