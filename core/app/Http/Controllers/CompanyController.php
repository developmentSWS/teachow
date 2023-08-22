<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Company;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;
use App\Models\Claim;
use Auth;

class CompanyController extends Controller
{
    public function __construct()
    {
        $this->activeTemplate = activeTemplate();
    }

    public function index()
    {
        $pageTitle      = "My Institute's";
        $emptyMessage   = "No Institute yet";
        $companies      = Company::where('user_id', auth()->id())->withAvg('reviews', 'rating')
            ->withCount('reviews')->latest()
            ->paginate(getPaginate());
        return view($this->activeTemplate . 'user.company.index', compact('pageTitle', 'emptyMessage', 'companies'));
    }


    public function create()
    {
        $categories = Category::where('status', 1)->orderBy('name')->get();
        $pageTitle = 'Add New Institute';
        return view($this->activeTemplate . 'user.company.create', compact('pageTitle', 'categories'));
    }

    public function edit($id)
    {
        $company = Company::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        $categories = Category::orderBy('name')->get();
        $pageTitle = 'Edit Institute';
        return view($this->activeTemplate . 'user.company.edit', compact('pageTitle', 'categories', 'company'));
    }

    public function claimInstituteProfile($id)
    {
        $company = Company::where('id', $id)->firstOrFail();
        $user = Auth::user();
       if(empty($user->firstname) || empty($user->lastname) || empty($user->email) || empty($user->mobile))
       {
            $notify[] = ['success', 'Please update your details first'];
            return redirect()->route('user.profile.setting')->withNotify($notify);
       }
        $pageTitle = 'Claim Institute Profile';
        return view($this->activeTemplate . 'company.claim-institute', compact('pageTitle', 'company'));
    }

    public function saveInstituteClaimFrom(Request $request, $id)
    {
        $request->validate([
            'image'  => ['required', 'image', new FileTypeValidate(['jpg', 'jpeg', 'png', 'webp', 'pdf'])],
        ]);

        $teacher = Company::where('id', $id)->first();
        if($teacher)
        {
            $claim = new Claim();
            $claim->user_id = auth()->id();
            $claim->t_i_id = $id;
            $claim->status = 0; 
            $claim->type = "institute";
            if ($request->hasFile('image')) {
                $location       = imagePath()['company']['path'];
                $size           = imagePath()['company']['size'];
                $filename       = uploadImage($request->image, $location, $size, $claim->document);
                $claim->document = $filename;
            }
            $claim->save(); 
            $notify[] = ['success', 'Institute Profile Claim Request Sent to Admin! Wait For Admin Approval'];
            return redirect()->route('company.all')->withNotify($notify);

        }else {
            $notify[] = ['success', 'Institute Record Not Found'];
            return redirect()->back()->withNotify($notify);
        }    
    }


    public function store(Request $request){
        $this->validation($request);
        $company = new Company();
        $this->saveCompany($company, $request);
        $notify[] = ['success', 'Company added successfully'];
        return redirect()->route('user.company')->withNotify($notify);
    }

    public function update(Request $request, $id){
        $this->validation($request, $id, 'nullable');
        $company = Company::findOrFail($id);
        $this->saveCompany($company, $request);
        $notify[] = ['success', 'Company updated successfully'];
        return back()->withNotify($notify);
    }


    protected function validation($request, $id = 0, $imgValidation = 'required')
    {
        $request->validate(
            [
                'name'          => 'required|string|max:40|unique:companies,name,' . $id,
                'category'      => 'required|integer|exists:categories,id|gt:0',
                'image'         => [$imgValidation, 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
                'url'           => 'nullable|url',
                'email'         => 'nullable|email|unique:companies,email,' . $id,
                'address'       => 'required|string',
                'description'   => 'required|string',
                'tags'          => 'required|array|min:1',
                'tags.*'        => 'string|max:40',
            ]
        );
    }
    protected function saveCompany($company, $request)
    {
       

        if ($request->hasFile('image')) {
            $location       = imagePath()['company']['path'];
            $size           = imagePath()['company']['size'];
            $filename       = uploadImage($request->image, $location, $size, $company->image);
            $company->image  = $filename;
        }



        $company->category_id = $request->category;
        $company->user_id     = auth()->id();
        $company->name        = $request->name;
        $company->url         = $request->url;
        $company->email       = $request->email;
        $company->address     = $request->address;
        $company->description = $request->description;
        $company->tags        = $request->tags;
        $company->status      = 0;
        $company->save();
    }
}
