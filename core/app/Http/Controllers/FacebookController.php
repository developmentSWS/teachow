<?php

namespace App\Http\Controllers;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Http\Request;

class FacebookController extends Controller
{
    public function redirectFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function facebookCallback()
    {
        try {
        
            $user = Socialite::driver('facebook')->user();
         
            $finduser = User::where('facebook_id', $user->id)->first();
        
            if($finduser){
         
                Auth::login($finduser);
        
                return redirect()->route('user.home');
         
            }else{
                $newUser = User::create([
                    'username' => $user->name,
                    'email' => $user->email,
                    'facebook_id'=> $user->id,
                    'password' => encrypt('Test123456')
                ]);
        
                Auth::login($newUser);
        
                return redirect()->route('user.home');
            }
        
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}