<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class ThirdPartyLoginController extends Controller
{
    public function oauthLogin(string $driver) {
        return Socialite::driver($driver)->redirect();
    }

    public function oauthRedirect(string $driver) {
        $oauthUser = Socialite::driver($driver)->user();
        
        $user = User::firstOrCreate([
            'oauth_id' => $oauthUser->getId(),
            'oauth_source' => $driver,
        ], [
            'name' => $oauthUser->getName(),
            'password' => Hash::make(Str::random(24)),
            'email' => $oauthUser->email,
            'oauth_token' => $oauthUser->token,
            'oauth_refresh' => $oauthUser->refreshToken,
            'avatar' => $oauthUser->getAvatar(),
        ]);

        Auth::login($user);

        return redirect(route('home'));
    }
}
