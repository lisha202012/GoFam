<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            $user = User::where('email', $googleUser->getEmail())->first();
            if ($user) {
                if (!$user->google_id) {
                    return redirect()->route('login')->with('error', 'This email is already registered. Please log in using your password.');
                }
            } else {
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'password' => null, 
                    'google_id' => $googleUser->getId(),
                ]);
            }
            Auth::login($user);
            return redirect()->route('dashboard')->with('success', 'Google Login Successful!');
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Google Login Failed! ' . $e->getMessage());
        }
    }
}

