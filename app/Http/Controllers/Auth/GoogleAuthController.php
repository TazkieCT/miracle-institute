<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\SocialAccount;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Throwable $e) {
            return redirect()
                ->route('login')
                ->withErrors(['oauth' => 'Google login gagal. Silakan coba lagi.']);
        }

        if (!$googleUser->getEmail()) {
            return redirect()
                ->route('login')
                ->withErrors(['oauth' => 'Google tidak mengembalikan email.']);
        }

        $account = SocialAccount::where('provider', 'google')
            ->where('provider_user_id', $googleUser->getId())
            ->first();

        if ($account) {
            Auth::login($account->user, true);
            return redirect()->intended(route('dashboard'));
        }

        $user = User::where('email', $googleUser->getEmail())->first();

        if (!$user) {
            $user = User::create([
                'id' => (string) Str::uuid(),
                'first_name' => $googleUser->user['given_name'] ?? $googleUser->getName() ?? 'Google',
                'last_name' => $googleUser->user['family_name'] ?? 'User',
                'email' => $googleUser->getEmail(),
                'password' => bcrypt(Str::random(40)),
                'email_verified_at' => now(),
                'image' => $googleUser->getAvatar(),
            ]);

            $studentRole = Role::where('name', 'student')->first();
            if ($studentRole) {
                $user->roles()->attach($studentRole->id, [
                    'assigned_at' => now(),
                ]);
            }
        } elseif (!$user->email_verified_at) {
            $user->forceFill(['email_verified_at' => now()])->save();
        }

        SocialAccount::create([
            'id' => (string) Str::uuid(),
            'user_id' => $user->id,
            'provider' => 'google',
            'provider_user_id' => $googleUser->getId(),
            'provider_email' => $googleUser->getEmail(),
            'token' => $googleUser->token ?? null,
            'refresh_token' => $googleUser->refreshToken ?? null,
            'expires_at' => isset($googleUser->expiresIn) ? now()->addSeconds($googleUser->expiresIn) : null,
        ]);

        Auth::login($user, true);

        return redirect()->intended(route('dashboard'));
    }
}