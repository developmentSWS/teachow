<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use App\Models\Category;
use App\Models\Company;
use Illuminate\Http\Request;

class ManageCompanyController extends Controller
{
    protected $pageTitle;
    protected $emptyMessage;

    public function index()
    {
        $segments       = request()->segments();
        $companies      = $this->filterCompanies(end($segments));
        $pageTitle      = $this->pageTitle;
        $emptyMessage   = $this->emptyMessage;
        $categories     = Category::orderBy('id', 'DESC')->get();
        return view('admin.company.index', compact('pageTitle', 'emptyMessage', 'categories', 'companies'));
    }

    protected function filterCompanies($type)
    {
        $this->pageTitle    = ucfirst($type) . ' Institute';
        $this->emptyMessage = 'No ' . $type . ' Institute found';
        $companies          = Company::query();

        if (request()->search) {
            $search         = request()->search;
            $companies      = $companies->where('name', 'like', "%$search%")->orWhere(function ($q) use ($search) {
                $q->whereHas('user', function ($user) use ($search) {
                    $user->where('username', 'like', "%$search%");
                })->orWhereHas('category', function ($question) use ($search) {
                    $question->where('name', 'like', "%$search%");
                });
            });

            $this->pageTitle    = "Search Result for '$search'";
        }

        if ($type != 'all') {
            $companies = $companies->$type();
        }

        return $companies->with('category', 'user')->latest()->paginate(getPaginate());
    }

    public function details($id)
    {
        $company = Company::where('id', $id)->with('user', 'category')->firstOrFail();
        $pageTitle = ucfirst($company->user->fullname) . ' Requested Institute';
        return view('admin.company.details', compact('pageTitle', 'company'));
    }

    public function approve(Request $request)
    {
        $request->validate(['id' => 'required|integer']);

        $company = Company::where('id', $request->id)->with('user')->firstOrFail();
        $company->status = 1;
        $company->admin_feedback = $request->details;
        $company->save();
        $general = GeneralSetting::first();
        notify($company->user, 'COMPANY_APPROVED', [
            'name' => $company->name,
            'site' => $general->sitename,
            'feedback' => $company->admin_feedback,
        ]);

        $notify[] = ['success', 'Institute request approved successfully'];
        return redirect()->route('admin.company.approved')->withNotify($notify);
    }

    public function reject(Request $request)
    {
        $request->validate(['id' => 'required|integer']);
        $company = Company::where('id', $request->id)->with('user')->firstOrFail();
        $company->status = 2;
        $company->admin_feedback = $request->details;
        $company->save();
        $general = GeneralSetting::first();
        notify($company->user, 'COMPANY_REJECTED', [
            'name' => $company->name,
            'site' => $general->sitename,
            'feedback' => $company->admin_feedback,
        ]);
        $notify[] = ['success', 'Institute request rejected successfully'];
        return redirect()->route('admin.company.rejected')->withNotify($notify);
    }
}
