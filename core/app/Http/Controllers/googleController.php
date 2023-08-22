<?php

namespace App\Http\Controllers;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Http\Request;

class googleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
      
            $user = Socialite::driver('google')->user();
       
            $finduser = User::where('google_id', $user->id)->orWhere('email', $user->email)->first();
        // dd($finduser);
            if($finduser){
                
                if (empty($finduser->google_id)) {
                    // Link the Google ID to the existing user
                    $finduser->google_id = $user->id;
                    $finduser->save();
                }
       
                Auth::login($finduser);
                
                if(session('link') != null)
                {
                    return redirect(session('link'));
                }else {
                    return redirect()->route('user.home');
                }
      
                // return redirect()->route('user.home');
       
            }else{
                $newUser = User::create([
                    'firstname' => $user->given_name,
                    'lastname' => $user->family_name,
                    'username' => $user->name,
                    'email' => $user->email,
                    'google_id'=> $user->id,
                    'password' => encrypt('123456dummy'),
                    'address' => [
                            'address' => '',
                            'state' => '',
                            'zip' => '',
                            'country' => 'IN',
                            'city' => ''
                        ],
                    'status' => 1,
                    'ev' => 1,
                    'sv' => 1
                ]);
      
                Auth::login($newUser);
                
                if(session('link') != null)
                {
                    return redirect(session('link'));
                }else {
                    return redirect()->route('user.home');
                }
      
                // return redirect()->route('user.home');
            }
      
        } catch (Exception $e) {
            // dd($e->getMessage());
             $notify[] = ['success', 'Something Went Wrong! please try again later'];
              return redirect('login')->withNotify($notify);
        }
    }
}