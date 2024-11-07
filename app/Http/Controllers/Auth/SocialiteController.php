<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback($provider)
    {
        $socialUser = Socialite::driver($provider)->user();

        $registeredUser = User::where('provider_id', $socialUser->id)
            ->where('provider_name', $provider)
            ->first();

        if ($registeredUser) {
            Auth::login($registeredUser);
            return redirect('admin/dashboard');
        } else {
            $user = User::updateOrCreate([
                'provider_id' => $socialUser->id,
                'provider_name' => $provider,
            ], [
                'name' => $socialUser->name,
                'email' => $socialUser->email,
                'password' => hash('sha256', $socialUser->email),
                'access_token' => $socialUser->token,
                'refresh_token' => $socialUser->refreshToken,
            ]);
        }

        Auth::login($user);

        return redirect('/admin/dashboard');
    }
}