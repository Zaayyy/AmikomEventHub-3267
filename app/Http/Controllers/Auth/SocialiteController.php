<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    private function getGoogleProvider()
    {
        $clientId = trim(env('GOOGLE_CLIENT_ID') ?: config('services.google.client_id') ?: '');
        $clientSecret = trim(env('GOOGLE_CLIENT_SECRET') ?: config('services.google.client_secret') ?: '');
        
        $envRedirect = trim(env('GOOGLE_REDIRECT_URI') ?: config('services.google.redirect') ?: '');
        if ($envRedirect && !str_contains($envRedirect, '/auth/google/callback')) {
            $envRedirect = rtrim($envRedirect, '/') . '/auth/google/callback';
        }
        $redirectUrl = $envRedirect ?: url('/auth/google/callback');

        return Socialite::buildProvider(
            \Laravel\Socialite\Two\GoogleProvider::class,
            [
                'client_id' => $clientId,
                'client_secret' => $clientSecret,
                'redirect' => $redirectUrl,
            ]
        )->stateless();
    }

    public function redirect()
    {
        return $this->getGoogleProvider()->redirect();
    }

    public function callback()
    {
        $googleUser = $this->getGoogleProvider()->user();

        $user = User::where('email', $googleUser->getEmail())->first();

        if (!$user) {

            $user = User::create([

                'name' => $googleUser->getName(),

                'email' => $googleUser->getEmail(),

                'password' => bcrypt(Str::random(16)),

                'role' => 'user',

                'google_id' => $googleUser->getId(),

                'avatar' => $googleUser->getAvatar(),

            ]);

        } else {

            $user->update([

                'google_id' => $googleUser->getId(),

                'avatar' => $googleUser->getAvatar(),

            ]);

        }

        Auth::login($user);

        return redirect()->route('home');
    }

    public function logout()
    {
        Auth::logout();

        request()->session()->invalidate();

        request()->session()->regenerateToken();

        return redirect()->route('home');
    }
}