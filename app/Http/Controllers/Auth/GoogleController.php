<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from Google.
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Find existing user by google_id or email
            $user = User::where('google_id', $googleUser->getId())
                ->orWhere('email', $googleUser->getEmail())
                ->first();

            if (! $user) {
                // Create a new user
                $user = User::create([
                    'name'      => $googleUser->getName() ?? $googleUser->getNickname() ?? 'Google User',
                    'email'     => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'avatar'    => $googleUser->getAvatar(),
                    'password'  => Hash::make(Str::random(24)),
                    'is_admin'  => false,
                ]);
            } else {
                // Link google_id if not already set
                $user->update([
                    'google_id' => $googleUser->getId(),
                    'avatar'    => $googleUser->getAvatar() ?? $user->avatar,
                ]);
            }

            Auth::login($user);

            return redirect()->intended('/dashboard')->with('success', 'Welcome! You have signed in with Google.');
        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Unable to sign in with Google. Please try again.');
        }
    }
}
