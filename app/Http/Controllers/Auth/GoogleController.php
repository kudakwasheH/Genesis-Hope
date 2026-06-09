<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Auth\Events\Registered;
use Exception;

class GoogleController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     *
     * @return RedirectResponse
     */
    public function redirectToGoogle(): RedirectResponse
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from Google.
     *
     * @return RedirectResponse
     */
    public function handleGoogleCallback(): RedirectResponse
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (Exception $e) {
            return redirect(route('login'))->withErrors([
                'email' => 'Unable to authenticate with Google. Please try again.',
            ]);
        }

        // Check if user already exists with this Google ID
        $user = User::where('google_id', $googleUser->getId())->first();

        if ($user) {
            Auth::login($user);
            return redirect(route('dashboard', absolute: false));
        }

        // Check if a user with the same email exists
        $user = User::where('email', $googleUser->getEmail())->first();

        if ($user) {
            // Update Google ID and log them in
            $user->update([
                'google_id' => $googleUser->getId(),
            ]);
            Auth::login($user);
            return redirect(route('dashboard', absolute: false));
        }

        // Create new user as a patient
        $user = User::create([
            'name' => $googleUser->getName(),
            'email' => $googleUser->getEmail(),
            'google_id' => $googleUser->getId(),
            'role' => 'patient', // default role for new registrations
            'password' => null, // no password for OAuth user
        ]);

        event(new Registered($user));
        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
