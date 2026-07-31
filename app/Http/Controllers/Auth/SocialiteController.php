<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    public function redirect()
    {
        $redirectUrl = env('GOOGLE_REDIRECT_URI') ?: url('/auth/google/callback');
        return Socialite::driver('google')->redirectUrl($redirectUrl)->stateless()->redirect();
    }

    public function callback()
    {
        $redirectUrl = env('GOOGLE_REDIRECT_URI') ?: url('/auth/google/callback');
        $googleUser = Socialite::driver('google')->redirectUrl($redirectUrl)->stateless()->user();

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