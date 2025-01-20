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
            return redirect('dashboard');
        } else {
            // Cari user terakhir berdasarkan ID terbaru
            $user = User::latest('id')->first();
            $kodeUser = "US";

            // Jika user terakhir belum ada
            if (!$user || !$user->id_user) {
                $id_user = $kodeUser . "001";
            } else {
                // Ambil id_user terakhir
                $id_user_terakhir = $user->id_user;

                // Pastikan id_user mengikuti format "USXXX"
                if (preg_match('/^US(\d{3})$/', $id_user_terakhir, $matches)) {
                    // Ambil angka terakhir, tambahkan 1
                    $urutan = (int) $matches[1] + 1;
                } else {
                    // Jika format tidak sesuai, reset ke 001
                    $urutan = 1;
                }

                // Format ulang ID user dengan padding nol di depan
                $id_user = $kodeUser . sprintf("%03d", $urutan);
            }

            // Create or update the user with Socialite data and generated id_number
            $user = User::updateOrCreate([
                'provider_id' => $socialUser->id,
                'provider_name' => $provider,
            ], [
                'name' => $socialUser->name,
                'email' => $socialUser->email,
                'password' => hash('sha256', $socialUser->email),
                'access_token' => $socialUser->token,
                'refresh_token' => $socialUser->refreshToken,
                'id_user' => $id_user, // Set id_number for the user
                'email_verified_at' => now(),
            ]);
        }

        Auth::login($user);

        return redirect('/dashboard');
    }
}