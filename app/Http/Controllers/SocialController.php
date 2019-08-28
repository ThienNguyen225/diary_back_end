<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Tymon\JWTAuth\Facades\JWTAuth;

class SocialController extends Controller
{
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function Callback($provider)
    {
        $userSocial = Socialite::driver($provider)->stateless()->user();
        $users = User::where(['email' => $userSocial->getEmail()])->first();

        $credentials = $users->only('email', 'password');
        $token = JWTAuth::attempt($credentials);

        if ($users) {
            Auth::login($users);
            return redirect('/');
        } else {
            $users = $this->createUser($userSocial, $provider);
            return redirect()->route('home');
        }
    }

    public function createUser($userSocial, $provider)
    {
        return User::create([
            'name' => $userSocial->getName(),
            'email' => $userSocial->getEmail(),
            'image' => $userSocial->getAvatar(),
            'provider_id' => $userSocial->getId(),
            'provider' => $provider,
        ]);
    }
}
