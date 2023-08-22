<?php

namespace App\Http\Controllers;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Http\Request;

class LinkedinController extends Controller
{
    public function linkedinRedirect()
    {
        return Socialite::driver('linkedin')->redirect();
    }
       
    public function linkedinCallback()
    {
        try {
     
            $user = Socialite::driver('linkedin')->user();
      
            $linkedinUser = User::where('oauth_id', $user->id)->first();
      
            if($linkedinUser){
      
                Auth::login($linkedinUser);
     
                return redirect()->route('user.home');
      
            }else{
                $user = User::create([
                    'username' => $user->name,
                    'email' => $user->email,
                    'oauth_id' => $user->id,
                    'oauth_type' => 'linkedin',
                    'password' => encrypt('admin12345')
                ]);
     
                Auth::login($user);
      
                return redirect()->route('user.home');
            }
     
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}