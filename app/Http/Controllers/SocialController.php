<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use File;

class SocialController extends Controller
{
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider)
    {
        $getUserInfo = Socialite::driver($provider)->stateless()->user();
        $user = $this->createUser($getUserInfo, $provider);
        auth()->login($user);

        return redirect()->to('/');
    }

    public function createUser($getUserInfo, $provider)
    {
        $user = User::where('provider_id', $getUserInfo->id)->first();

        if (!$user) {
            // $user = User::create([
            //     'name'  => $getUserInfo->name,
            //     'email' => $getUserInfo->email,
            //     'provider' => $provider,
            //     'provider_id' => $getUserInfo->id,
            // ]);
            $avatar_name = $this->avatarUpload($getUserInfo);

            $user = new User();
            $user->name = $getUserInfo->name;
            $user->email = $getUserInfo->email;
            $user->photo = $avatar_name;
            $user->provider = $provider;
            $user->provider_id = $getUserInfo->id;
            $user->save();
        }

        return $user;
    }

    public function avatarUpload($getUserInfo)
    {
        $avatar = file_get_contents($getUserInfo->avatar_original);
        $avatar_name = 'users/' . $getUserInfo->name . '_' . $getUserInfo->id . ".jpeg";
        File::put(storage_path() . '/app/public/' . $avatar_name, $avatar);

        return $avatar_name;
    }
}