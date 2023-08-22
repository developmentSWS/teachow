<?php

namespace App\Http\Controllers;

use App\Lib\GoogleAuthenticator;
use App\Models\Company;
use App\Models\GeneralSetting;
use App\Models\Review;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Models\TeacherReview;
use App\Models\Teacher;
use App\Models\User;
use Session;
use App\Models\PasswordReset;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Foundation\Auth\ResetsPasswords;


class UserController extends Controller
{
    use SendsPasswordResetEmails;

    public function __construct()
    {
        $this->activeTemplate = activeTemplate();
    }

    public function home()
    {
        $pageTitle = 'Dashboard';
        $emptyMessage = 'No review yet';
        $reviews = auth()->user()->reviews()->with('company')->latest()->paginate(getPaginate());
        $treviews = auth()->user()->treviews()->with('teacher')->latest()->paginate(getPaginate());
        // dd($treviews);
        if(!$reviews->count() && !$treviews->count()) { 
            return redirect()->route('user.profile.setting');
        }

        return view($this->activeTemplate . 'user.dashboard', compact('pageTitle', 'reviews', 'treviews'));
    }

    public function updateReview(Request $request)
    {
        // dd($request->all());
        $request->validate(
            [
                'rating' => 'nullable|integer|min:1|max:5',
                'teaching_faculty' => 'nullable|integer|min:1|max:5',
                'infra_quality' => 'nullable|integer|min:1|max:5',
                'technology_friendly' => 'nullable|integer|min:1|max:5',
                'counseling_quality' => 'nullable|integer|min:1|max:5',
                'operational_manage' => 'nullable|integer|min:1|max:5',
                'attitude_management' => 'nullable|integer|min:1|max:5',
                'quality_classroom' => 'nullable|integer|min:1|max:5',
                'tests' => 'nullable|integer|min:1|max:5',
                'quality_study' => 'nullable|integer|min:1|max:5',
                'current_affair' => 'nullable|integer|min:1|max:5',
                'interview_guidance' => 'nullable|integer|min:1|max:5',
                'review' => 'required|string',
            ]
        );

        $review = Review::where('id', $request->id)->where('user_id', auth()->id())->firstOrFail();

        $review->rating = $request->rating ?? $review->rating;
        $review->teaching_faculty  = $request->teaching_faculty ?? $review->teaching_faculty;
        $review->infra_quality  = $request->infra_quality ?? $review->infra_quality;
        $review->technology_friendly  =  $request->technology_friendly ?? $review->technology_friendly;
        $review->counseling_quality  = $request->counseling_quality ?? $review->counseling_quality;
        $review->operational_manage  = $request->operational_manage ?? $review->operational_manage;
        $review->attitude_management  = $request->attitude_management ?? $review->attitude_management;
        $review->quality_classroom  = $request->quality_classroom ?? $review->quality_classroom;
        $review->tests  = $request->tests ?? $review->tests;
        $review->quality_study  = $request->quality_study ?? $review->quality_study;
        $review->current_affair  = $request->current_affair ?? $review->current_affair;
        $review->interview_guidance  = $request->interview_guidance ?? $review->interview_guidance;
        $review->review = $request->review;
        $review->save();

        $company = Company::where('id', $review->company_id)->first();
        $reviews = Review::where('company_id', $company->id)->get(['rating']);

        $company->avg_rating = $reviews->sum('rating') / $reviews->count();
        $company->save();

        $notify[] = ['success', 'Successfully review updated'];
        return back()->withNotify($notify);
    }

    public function updateTeacherReview(Request $request)
    {

        // dd($request->all());
        $request->validate(
            [
                'rating' => 'nullable|integer|min:1|max:5',
                'friendliness_teaching' => 'nullable|integer|min:1|max:5',
                'clarity_of_concept' => 'nullable|integer|min:1|max:5',
                'clarity_of_concept' => 'nullable|integer|min:1|max:5',
                'student_engage' => 'nullable|integer|min:1|max:5',
                'punctuality' => 'nullable|integer|min:1|max:5',
                'content_validity' => 'nullable|integer|min:1|max:5',
                'syllabus_completed' => 'nullable|integer|min:1|max:5',
                'review' => 'nullable|string',
            ]
        );

        $review = TeacherReview::where('id', $request->id)->where('user_id', auth()->id())->firstOrFail();
        // dd($review);
        $review->rating  = $request->rating ?? $review->rating;
        $review->friendliness_teaching  = $request->friendliness_teaching ?? $review->friendliness_teaching;
        $review->clarity_of_concept  = $request->clarity_of_concept ?? $review->clarity_of_concept;
        $review->communication  = $request->communication ?? $review->communication;
        $review->student_engage  = $request->student_engage ?? $review->student_engage;
        $review->punctuality  = $request->punctuality ?? $review->punctuality;
        $review->content_validity  = $request->content_validity ?? $review->content_validity;
        $review->syllabus_completed  = $request->syllabus_completed ?? $review->syllabus_completed;
        $review->review = $request->review;
        $review->save();

        $company = Teacher::where('id', $review->teacher_id)->first();
        $reviews = TeacherReview::where('teacher_id', $company->id)->get(['rating']);

        $company->avg_rating = $reviews->sum('rating') / $reviews->count();
        $company->save();

        $notify[] = ['success', 'Successfully review updated'];
        return back()->withNotify($notify);
    }


    public function deleteReview(Request $request)
    {
        $review     = Review::where('id', $request->id)->where('user_id', auth()->id())->firstOrFail();
        $company    = Company::find($review->company_id);
        $review->delete();
        $reviews = Review::where('company_id', $company->id)->get(['rating']);
        $company->avg_rating = 0;
        if ($reviews->count()) {
            $company->avg_rating = $reviews->sum('rating')  / $reviews->count();
        }
        $company->save();
        $notify[] = ['success', 'Successfully review deleted'];
        return back()->withNotify($notify);
    }

    public function deleteTeacherReview(Request $request)
    {
        $review     = TeacherReview::where('id', $request->id)->where('user_id', auth()->id())->firstOrFail();
        $company    = Teacher::find($review->teacher_id);
        $review->delete();
        $reviews = TeacherReview::where('teacher_id', $company->id)->get(['rating']);
        $company->avg_rating = 0;
        if ($reviews->count()) {
            $company->avg_rating = $reviews->sum('rating')  / $reviews->count();
        }
        $company->save();
        $notify[] = ['success', 'Successfully review deleted'];
        return back()->withNotify($notify);
    }


    public function profile()
    {
        $pageTitle = "Profile Setting";
        $user = Auth::user();
        if(Session::has('verificationSuccess'))
        {
            Session::forget('verificationSuccess');
            return redirect()->route('user.registersuccess');
        }
        return view($this->activeTemplate . 'user.profile_setting', compact('pageTitle', 'user'));
    }

    public function submitProfile(Request $request)
    {
        $request->validate([
            'firstname' => 'required|string|max:50',
            'lastname'  => 'required|string|max:50',
            'address'   => 'nullable|string|max:80',
            'state'     => 'nullable|string|max:80',
            'zip'       => 'nullable|string|max:40',
            'city'      => 'nullable|string|max:50',
            'image'     => ['image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
            'about'     => 'nullable|string|max:500',
        ], [
            'firstname.required' => 'First name field is required',
            'lastname.required' => 'Last name field is required'
        ]);

        $user = Auth::user();

        $in['firstname'] = $request->firstname;
        $in['lastname'] = $request->lastname;
        $in['address'] = [
            'address'   => $request->address,
            'state'     => $request->state,
            'zip'       => $request->zip,
            'country'   => @$user->address->country,
            'city'      => $request->city,
        ];

        if ($request->hasFile('image')) {
            $location = imagePath()['profile']['user']['path'];
            $size = imagePath()['profile']['user']['size'];
            $filename = uploadImage($request->image, $location, $size, $user->image);
            $in['image'] = $filename;
        }
        $in['about'] = $request->about;
        $user->fill($in)->save();
        $notify[] = ['success', 'Profile updated successfully'];
        return back()->withNotify($notify);
    }

    public function changePassword()
    {
        $pageTitle = 'Change password';
        return view($this->activeTemplate . 'user.password', compact('pageTitle'));
    }

    public function showLinkRequestForm()
    {
        $pageTitle = "Reset Password";
        return view(activeTemplate() . 'user.auth.passwords.email1', compact('pageTitle'));
    }

    public function sendResetCodeEmail(Request $request)
    {
        if ($request->type == 'email') {
            $validationRule = [
                'value'=>'required|email'
            ];
            $validationMessage = [
                'value.required'=>'Email field is required',
                'value.email'=>'Email must be a valid email'
            ];
        }elseif($request->type == 'username'){
            $validationRule = [
                'value'=>'required'
            ];
            $validationMessage = ['value.required'=>'Username field is required'];
        }else{
            $notify[] = ['error','Invalid selection'];
            return back()->withNotify($notify);
        }

        $request->validate($validationRule,$validationMessage);

        $user = User::where($request->type, $request->value)->first();

        if (!$user) {
            $notify[] = ['error', 'User not found.'];
            return back()->withNotify($notify);
        }

        PasswordReset::where('email', $user->email)->delete();
        $code = verificationCode(6);
        $password = new PasswordReset();
        $password->email = $user->email;
        $password->token = $code;
        $password->created_at = \Carbon\Carbon::now();
        $password->save();

        $userIpInfo = getIpInfo();
        $userBrowserInfo = osBrowser();
        sendEmail($user, 'PASS_RESET_CODE', [
            'code' => $code,
            'operating_system' => @$userBrowserInfo['os_platform'],
            'browser' => @$userBrowserInfo['browser'],
            'ip' => @$userIpInfo['ip'],
            'time' => @$userIpInfo['time']
        ]);

        $pageTitle = 'Account Recovery';
        $email = $user->email;
        session()->put('pass_res_mail',$email);
        $notify[] = ['success', 'Password reset email sent successfully'];
        return redirect()->route('user.password.code.verifynew')->withNotify($notify);
    }

    public function codeVerify(){
        $pageTitle = 'Account Recovery';
        $email = session()->get('pass_res_mail');
        if (!$email) {
            $notify[] = ['error','Oops! session expired'];
            return redirect()->route('user.password.requestnew')->withNotify($notify);
        }
        return view(activeTemplate().'user.auth.passwords.code_verify1',compact('pageTitle','email'));
    }


    public function verifyCode(Request $request)
    {
        $request->validate([
            'code' => 'required',
            'email' => 'required'
        ]);
        $code =  str_replace(' ', '', $request->code);

        if (PasswordReset::where('token', $code)->where('email', $request->email)->count() != 1) {
            $notify[] = ['error', 'Invalid token'];
            return redirect()->route('user.password.requestnew')->withNotify($notify);
        }
        $notify[] = ['success', 'You can change your password.'];
        session()->flash('fpass_email', $request->email);
        return redirect()->route('user.password.resetnew', $code)->withNotify($notify);
    }

    public function showResetForm(Request $request, $token = null)
    {

        $email = session('fpass_email');
        $token = session()->has('token') ? session('token') : $token;
        if (PasswordReset::where('token', $token)->where('email', $email)->count() != 1) {
            $notify[] = ['error', 'Invalid token'];
            return redirect()->route('user.password.requestnew')->withNotify($notify);
        }
        return view(activeTemplate() . 'user.auth.passwords.reset')->with(
            ['token' => $token, 'email' => $email, 'pageTitle' => 'Reset Password']
        );
    }

    public function reset(Request $request)
    {

        session()->put('fpass_email', $request->email);
        $request->validate($this->rules(), $this->validationErrorMessages());
        $reset = PasswordReset::where('token', $request->token)->orderBy('created_at', 'desc')->first();
        if (!$reset) {
            $notify[] = ['error', 'Invalid verification code'];
            return redirect()->route('user.login')->withNotify($notify);
        }

        $user = User::where('email', $reset->email)->first();
        $user->password = bcrypt($request->password);
        $user->save();



        $userIpInfo = getIpInfo();
        $userBrowser = osBrowser();
        sendEmail($user, 'PASS_RESET_DONE', [
            'operating_system' => @$userBrowser['os_platform'],
            'browser' => @$userBrowser['browser'],
            'ip' => @$userIpInfo['ip'],
            'time' => @$userIpInfo['time']
        ]);


        $notify[] = ['success', 'Password changed successfully'];
        return redirect()->route('user.login')->withNotify($notify);
    }


    public function submitPassword(Request $request)
    {

        $password_validation = Password::min(6);
        $general = GeneralSetting::first();

        if ($general->secure_password) {
            $password_validation = $password_validation->mixedCase()->numbers()->symbols()->uncompromised();
        }

        $this->validate($request, [
            'current_password' => 'required',
            'password' => ['required', 'confirmed', $password_validation]
        ]);

        try {
            $user = auth()->user();
            if (Hash::check($request->current_password, $user->password)) {
                $password = Hash::make($request->password);
                $user->password = $password;
                $user->save();
                $notify[] = ['success', 'Password changed successfully'];
                return back()->withNotify($notify);
            } else {
                $notify[] = ['error', 'The password doesn\'t match!'];
                return back()->withNotify($notify);
            }
        } catch (\PDOException $e) {
            $notify[] = ['error', $e->getMessage()];
            return back()->withNotify($notify);
        }
    }
}
