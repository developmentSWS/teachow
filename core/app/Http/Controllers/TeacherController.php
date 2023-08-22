<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Company;
use App\Models\Teacher;
use App\Models\Claim;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;
use Auth;

class TeacherController extends Controller
{
    public function __construct()
    {
        $this->activeTemplate = activeTemplate();
    }

    public function index()
    {
        $pageTitle      = "My Teacher's";
        $emptyMessage   = "No Teacher yet";
        $companies      = Teacher::where('user_id', auth()->id())->withAvg('treviews', 'rating')
            ->withCount('treviews')->latest()
            ->paginate(getPaginate());
        return view($this->activeTemplate . 'user.teacher.index', compact('pageTitle', 'emptyMessage', 'companies'));
    }

    public function create()
    {
        $categories = Company::where('status', 1)->orderBy('name')->get();
        $pageTitle = 'Add New Teacher';
        return view($this->activeTemplate . 'user.teacher.create', compact('pageTitle', 'categories'));
    }

    public function claimTeacherProfile($id)
    { 
       $teacher = Teacher::where('id', $id)->firstOrFail();
       $user = Auth::user();
       if(empty($user->firstname) || empty($user->lastname) || empty($user->email) || empty($user->mobile))
       {
            $notify[] = ['success', 'Please update your details first'];
            return redirect()->route('user.profile.setting')->withNotify($notify);
       }
    //   dd($user);
       $pageTitle = 'Claim Teacher Profile';
       return view($this->activeTemplate . 'teacher.claim-teacher', compact('pageTitle', 'teacher'));
    }

    public function saveTeacherClaimFrom(Request $request, $id)
    {
        $request->validate([
            'image'  => ['required', 'image', new FileTypeValidate(['jpg', 'jpeg', 'png', 'webp', 'pdf'])],
        ]);

        $teacher = Teacher::where('id', $id)->first();
        if($teacher)
        {
            $claim = new Claim();
            $claim->user_id = auth()->id();
            $claim->t_i_id = $id;
            $claim->status = 0;
            $claim->type = "teacher";
            if ($request->hasFile('image')) {
                $location       = imagePath()['company']['path'];
                $size           = imagePath()['company']['size'];
                $filename       = uploadImage($request->image, $location, $size, $claim->document);
                $claim->document = $filename;
            }
            $claim->save(); 
            $notify[] = ['success', 'Teacher Profile Claim Request Sent to Admin! Wait For Admin Approval'];
            return redirect()->route('teacher.all')->withNotify($notify);

        }else {
            $notify[] = ['success', 'Teacher Record Not Found'];
            return redirect()->back()->withNotify($notify);
        }    
        // dd($request->all());
       

    }

    public function edit($id)
    {
        $company = Teacher::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        $categories = Company::where('status', 1)->orderBy('name')->get();
        $pageTitle = 'Edit Teacher';
        return view($this->activeTemplate . 'user.teacher.edit', compact('pageTitle', 'categories', 'company'));
    }

    public function store(Request $request){
        // dd($request->all());
        $this->validation($request);
        $company = new Teacher();
        $this->saveTeacher($company, $request);
        $notify[] = ['success', 'Teacher added successfully'];
        return redirect()->route('user.teacher')->withNotify($notify);
    }

    public function update(Request $request, $id){
        $this->validation($request, $id, 'nullable');
        $company = Teacher::findOrFail($id);
        $this->saveTeacher($company, $request);
        $notify[] = ['success', 'Teacher updated successfully'];
        return back()->withNotify($notify);
    }

    protected function validation($request, $id = 0, $imgValidation = 'nullable')
    {
        $request->validate(
            [
                'name'          => 'required|string|max:40',
                'category'      => 'nullable',
                'image'         => [$imgValidation, 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
                // 'url'           => 'required|url',
                'email'         => 'nullable|email|unique:teachers,email,' . $id,
                'subject'       => 'required|string',
                'location'      => 'nullable|string',
                'experience'   => 'nullable|string',
                'tags'          => 'nullable',
                'tags.*'        => 'string|max:40',
            ]
        );
    }

    protected function saveTeacher($company, $request)
    {
        // dd($request->all());

        if ($request->hasFile('image')) {
            $location       = imagePath()['company']['path'];
            $size           = imagePath()['company']['size'];
            $filename       = uploadImage($request->image, $location, $size, $company->image);
            $company->image  = $filename;
        }else {
            if($request->rmimage == 'abb')
            {
                $company->image  = null;
            }
        }

        $company->institute = is_array($request->category) ? implode(',', $request->category) : '';
        $company->user_id     = auth()->id();
        $company->name        = $request->name;
        // $company->url         = $request->url;
        $company->email       = $request->email;
        $company->address     = $request->subject;
        $company->location     = $request->location;
        $company->description = $request->experience;
        $company->tags        = $request->tags;
        $company->status      = 0;
        // dd($company);
        $company->save();
    }

}