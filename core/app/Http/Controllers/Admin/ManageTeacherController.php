<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use App\Models\Category;
use App\Models\Company;
use App\Models\Teacher;
use App\Models\Claim;
use App\Models\User;
use Illuminate\Http\Request;

class ManageTeacherController extends Controller
{
    protected $pageTitle;
    protected $emptyMessage;

    public function index() 
    {
        $segments       = request()->segments();
        // dd($segments);
        $companies      = $this->filterTeacher(end($segments));
        $pageTitle      = $this->pageTitle;
       
        $emptyMessage   = $this->emptyMessage;
        return view('admin.teacher.index', compact('pageTitle', 'emptyMessage', 'companies'));
    }

    public function filterTeacher($type)
    {
        $this->pageTitle    = ucfirst($type) . ' Teacher';
        $this->emptyMessage = 'No ' . $type . ' Teacher found';
        $companies          = Teacher::query();

        if (request()->search) {
            $search         = request()->search;
            $companies      = $companies->where('name', 'like', "%$search%")->orWhere(function ($q) use ($search) {
                $q->whereHas('user', function ($user) use ($search) {
                    $user->where('username', 'like', "%$search%");
                });
            });

            $this->pageTitle    = "Search Result for '$search'";
        }

        if ($type != 'all') {
            $companies = $companies->$type();
        }

        return $companies->with('user')->latest()->paginate(getPaginate());
    }

    public function details($id)
    {
        $teacher = Teacher::where('id', $id)->with('user')->firstOrFail();
        $pageTitle = ucfirst($teacher->user->fullname) . ' Requested Teacher';
        return view('admin.teacher.details', compact('pageTitle', 'teacher'));
    } 

    public function approve(Request $request)
    {
        $request->validate(['id' => 'required|integer']);

        $company = Teacher::where('id', $request->id)->with('user')->firstOrFail();
        $company->status = 1;
        $company->admin_feedback = $request->details;
        $company->save();
        $general = GeneralSetting::first();
        notify($company->user, 'TEACHER_APPROVED', [
            'name' => $company->name,
            'site' => $general->sitename,
            'feedback' => $company->admin_feedback,
        ]);

        $notify[] = ['success', 'Teacher request approved successfully'];
        return redirect()->route('admin.teacher.approved')->withNotify($notify);
    }

    public function reject(Request $request)
    {
        $request->validate(['id' => 'required|integer']);
        $company = Teacher::where('id', $request->id)->with('user')->firstOrFail();
        $company->status = 2;
        $company->admin_feedback = $request->details;
        $company->save();
        $general = GeneralSetting::first();
        notify($company->user, 'TEACHER_REJECTED', [
            'name' => $company->name,
            'site' => $general->sitename,
            'feedback' => $company->admin_feedback,
        ]);
        $notify[] = ['success', 'Teacher request rejected successfully'];
        return redirect()->route('admin.teacher.rejected')->withNotify($notify);
    }

    public function claimList()
    {
        $claimLists = Claim::latest()->paginate(getPaginate());
        if(!empty($claimLists))
        {
            foreach($claimLists as $claimList)
            {
                $user = User::where('id', $claimList->user_id)->firstOrFail();
                $claimList->user_name = $user->username;
                if($claimList->type == "teacher")
                {
                    $teacher = Teacher::where('id', $claimList->t_i_id)->firstOrFail();
                    $claimList->teacher = $teacher->name;
                }else {
                    $teacher = Company::where('id', $claimList->t_i_id)->firstOrFail();
                    $claimList->teacher = $teacher->name;
                }
                
            }
        }
        $pageTitle = 'Claim Request';
        return view('admin.claim.index', compact('pageTitle', 'claimLists'));
    }

    public function claimListApprove($id)
    {
        $claim = Claim::where('id', $id)->firstOrFail();
        if($claim->type == "teacher")
        {
            $teacher = Teacher::where('id', $claim->t_i_id)->firstOrFail();
            $teacher->user_id = $claim->user_id;
            $teacher->save();
        }
        if($claim->type == "institute")
        {
            $teacher = Company::where('id', $claim->t_i_id)->firstOrFail();
            $teacher->user_id = $claim->user_id;
            $teacher->save();
        }
        $claim->status = 1;
        $claim->save();
         $general = GeneralSetting::first();
         $user = User::where('id', $claim->user_id)->firstOrFail();
        notify($user, 'CLAIM_APPROVED', [
            'name' => $teacher->name,
            'site' => $general->sitename,
            'feedback' => 'Document Verified',
        ]);
        $notify[] = ['success', 'Claim request Apporved successfully'];
        return redirect()->route('admin.claim.list')->withNotify($notify);
    }
    
    public function claimListReject($id)
    {
        $claim = Claim::where('id', $id)->firstOrFail();
        if($claim->type == "teacher")
        {
            $teacher = Teacher::where('id', $claim->t_i_id)->firstOrFail();
            $teacher->user_id = $claim->user_id;
            $teacher->save();
        }
        if($claim->type == "institute")
        {
            $teacher = Company::where('id', $claim->t_i_id)->firstOrFail();
            $teacher->user_id = $claim->user_id;
            $teacher->save();
        }
        $claim->status = 2;
        $claim->save();
         $general = GeneralSetting::first();
         $user = User::where('id', $claim->user_id)->firstOrFail();
        notify($user, 'CLAIM_REJECTED', [
            'name' => $teacher->name,
            'site' => $general->sitename,
            'feedback' => 'Document Not Verified',
        ]);
        $notify[] = ['success', 'Claim request Rejected successfully'];
        return redirect()->route('admin.claim.list')->withNotify($notify);
    }

    public function claimListDelete($id)
    {
        $claim = Claim::where('id', $id)->firstOrFail();
        $old = $claim->document ?: null;
        $location = imagePath()['company']['path'];
        removeFile($location . '/' . $old);
        Claim::destroy($id);
        $notify[] = ['success', 'Claim request Deleted successfully'];
        return redirect()->route('admin.claim.list')->withNotify($notify);
    }

}