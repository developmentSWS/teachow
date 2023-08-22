<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\AdminNotification;
use App\Models\GeneralSetting;
use App\Models\User;
use App\Models\UserLogin;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Str;
use Session;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
        $this->middleware('regStatus')->except('registrationNotAllowed');

        $this->activeTemplate = activeTemplate();
    }

    public function showRegistrationForm()
    {
        $pageTitle = "Sign Up";
        $info = json_decode(json_encode(getIpInfo()), true);
        $mobile_code = is_array($info['code']) ? implode(',', $info['code']) : '';
        $countries = json_decode(file_get_contents(resource_path('views/partials/country.json')));
        return view($this->activeTemplate . 'user.auth.register', compact('pageTitle','mobile_code','countries'));
    }


    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
       
        $general = GeneralSetting::first();
        $password_validation = Password::min(6);
        if ($general->secure_password) {
            $password_validation = $password_validation->mixedCase()->numbers()->symbols()->uncompromised();
        }
        $agree = 'nullable';
        if ($general->agree) {
            $agree = 'required';
        }
        $countryData = (array)json_decode(file_get_contents(resource_path('views/partials/country.json')));
        $countryCodes = implode(',', array_keys($countryData));
        $mobileCodes = implode(',',array_column($countryData, 'dial_code'));
        $countries = implode(',',array_column($countryData, 'country'));
        $validate = Validator::make($data, [
            'firstname' => 'required|string|max:50',
            'lastname' => 'required|string|max:50',
            'email' => 'required|string|email|max:90|unique:users',
            'mobile' => 'required|string|max:50|unique:users',
            // 'password' => ['required','confirmed',$password_validation],
            // 'username' => 'required|unique:users|min:6',
            'captcha' => 'sometimes|required',
            // 'mobile_code' => 'required|in:'.$mobileCodes,
            // 'country_code' => 'required|in:'.$countryCodes,
            // 'country' => 'required|in:'.$countries,
            'agree' => $agree
        ]);
        return $validate;
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();
        $exist = User::where('mobile','LIKE', '%'.$request->mobile)->first();
        if ($exist) {
            $notify[] = ['error', 'The mobile number already exists'];
            return back()->withNotify($notify)->withInput();
        }

        if (isset($request->captcha)) {
            if (!captchaVerify($request->captcha, $request->captcha_secret)) {
                $notify[] = ['error', "Invalid captcha"];
                return back()->withNotify($notify)->withInput();
            }
        }
        $otp = rand(100000, 999999);
        $msg = 'One Time Password - '.$otp;
        sendGeneralEmail($request->email, 'OTP For Teachow Account', $msg, $request->firstname);    
        Session::put('loginDetails', $request->all());
        Session::put('createAccountOtp', $otp);
        return redirect()->route('user.otp');
       
    }

    public function OTP()
    {
        if(Session::has('createAccountOtp'))
        {
            $pageTitle = "OTP Verification";
            return view($this->activeTemplate . 'user.auth.otp', compact('pageTitle'));
        }else {
            $notify[] = ['error', "Please Fill Register Form Data First"];
            return redirect()->route('user.register')->withNotify($notify);
        }
       
    }

    public function OTPVerification(Request $request)
    {
        $request->validate([
           'sms_verified_code' => "required"
        ]);
        // dd(str_replace(' ', '', $request->sms_verified_code));
        $oldOtp = Session::get('createAccountOtp');
        $newotp = str_replace(' ', '', $request->sms_verified_code);

        if($oldOtp == $newotp)
        {  Session::put('verificationSuccess', 1);
            // return redirect()->route('user.registersuccess');
            $all_values  = Session::get('loginDetails');

            Session::forget('loginDetails');
            Session::forget('createAccountOtp');

            event(new Registered($user = $this->create($all_values)));
          
            $this->guard()->login($user);
            return redirect()->route('user.registersuccess');

        //  return $this->registered($request, $user)
        //     ?: redirect($this->redirectPath());
            // dd($all_values);
        }else {
            $notify[] = ['error', 'OTP Not Match'];
            return back()->withNotify($notify);
        }
    }

    public function registerSuccess()
    {
        if(Session::has('username') && Session::has('password'))
        {
            $pageTitle = "Verification Success";
            return view($this->activeTemplate . 'user.auth.verify_success', compact('pageTitle'));
        }else {
            $notify[] = ['error', "Something Went Wrong! You don't have permission to access this page"];
            return redirect()->route('user.register')->withNotify($notify);
        }    
    }


    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return \App\User
     */
    protected function create(array $data)
    {

        $general = GeneralSetting::first();

        $referBy = session()->get('reference');
        if ($referBy) {
            $referUser = User::where('username', $referBy)->first();
        } else {
            $referUser = null;
        }
        $newpassword = strtolower(Str::random(6));
        //User Create
        $user = new User();
        $user->firstname = isset($data['firstname']) ? $data['firstname'] : null;
        $user->lastname = isset($data['lastname']) ? $data['lastname'] : null;
        $user->email = strtolower(trim($data['email']));
        $user->password = Hash::make($newpassword);
        $user->student = 1;
        $user->honest_review = 1;
        $user->country_code = 'IN';
        $user->mobile = $data['mobile'];
        $user->address = [
            'address' => '',
            'state' => '',
            'zip' => '',
            'country' => 'IN',
            'city' => ''
        ];
        $user->status = 1;
        $user->ev = 1; //$general->ev ? 0 : 1;
        $user->sv = 1; //$general->sv ? 0 : 1;
        $user->save();

        $user->username = $data['firstname'].$user->id;
        $user->save();
        Session::put('username', $user->username);
        Session::put('password', $user->password);
        $msg = 'Username - '.$user->username.'<br> Password - '.$newpassword;

        sendGeneralEmail($user->email, 'Login Credentails For Teachow Account', $msg, $user->username);    
        $adminNotification = new AdminNotification();
        $adminNotification->user_id = $user->id;
        $adminNotification->title = 'New member registered';
        $adminNotification->click_url = urlPath('admin.users.detail',$user->id);
        $adminNotification->save();


        //Login Log Create
        $ip = $_SERVER["REMOTE_ADDR"];
        $exist = UserLogin::where('user_ip',$ip)->first();
        $userLogin = new UserLogin();

        //Check exist or not
        if ($exist) {
            $userLogin->longitude =  $exist->longitude;
            $userLogin->latitude =  $exist->latitude;
            $userLogin->city =  $exist->city;
            $userLogin->country_code = $exist->country_code;
            $userLogin->country =  $exist->country;
        }else{
            $info = json_decode(json_encode(getIpInfo()), true);
            $userLogin->longitude = is_array($info['long']) ? implode(',',$info['long']) : '';
            $userLogin->latitude =  is_array($info['lat']) ? implode(',',$info['lat']) : '';
            $userLogin->city =  is_array($info['city']) ? implode(',',$info['city']) : '';
            $userLogin->country_code = is_array($info['code']) ? implode(',',$info['code']) : '';
            $userLogin->country =  is_array($info['country']) ? implode(',', $info['country']) : '';
        }

        $userAgent = osBrowser();
        $userLogin->user_id = $user->id;
        $userLogin->user_ip =  $ip;

        $userLogin->browser = @$userAgent['browser'];
        $userLogin->os = @$userAgent['os_platform'];
        $userLogin->save();


        return $user;
    }

    public function checkUser(Request $request){
        $exist['data'] = null;
        $exist['type'] = null;
        if ($request->email) {
            $exist['data'] = User::where('email',$request->email)->first();
            $exist['type'] = 'email';
        }
        if ($request->mobile) {
            $exist['data'] = User::where('mobile', 'LIKE', '%'.$request->mobile)->first();
            $exist['type'] = 'mobile';
        }
        if ($request->username) {
            $exist['data'] = User::where('username',$request->username)->first();
            $exist['type'] = 'username';
        }
        return response($exist);
    }

    public function registered()
    {
        return redirect()->route('user.profile.setting');
    }

}
