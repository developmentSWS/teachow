<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Company;
use App\Models\TeacherReview;
use App\Models\Teacher;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    protected $pageTitle;
    protected $emptyMessage;
    public function index()
    {
        $segments       = request()->segments();
        $reviews        = $this->filterReviews();
        $pageTitle      = $this->pageTitle;
        $emptyMessage   = $this->emptyMessage;
        return view('admin.review.index', compact('pageTitle', 'emptyMessage', 'reviews'));
    }

    protected function filterReviews()
    {
        $this->pageTitle    = ucfirst(request()->search) . ' reviews';
        $this->emptyMessage = 'No ' . request()->search . ' review found';
        $reviews            = Review::query();

        if (request()->search) {
            $search         = request()->search;
            $reviews        = $reviews->where('review', 'like', "%$search%")->orWhere(function ($q) use ($search) {
                            $q->whereHas('user', function ($user) use ($search) {
                                $user->where('username', 'like', "%$search%");
                            })->orWhereHas('company', function ($question) use ($search) {
                                $question->where('name', 'like', "%$search%");
                            });
                        });
            $this->pageTitle    = "Search Result for '$search'";
        }
        return $reviews->with('company', 'user')->latest()->paginate(getPaginate());
    }

    public function teacherIndex()
    {
        $segments       = request()->segments();
        $reviews        = $this->filterteacherReviews();
        $pageTitle      = $this->pageTitle;
        $emptyMessage   = $this->emptyMessage;
        return view('admin.review.tindex', compact('pageTitle', 'emptyMessage', 'reviews'));
    }

    public function filterteacherReviews()
    {
        $this->pageTitle    = ucfirst(request()->search) . ' reviews';
        $this->emptyMessage = 'No ' . request()->search . ' review found';
        $reviews            = TeacherReview::query();

        if (request()->search) {
            $search         = request()->search;
            $reviews        = $reviews->where('review', 'like', "%$search%")->orWhere(function ($q) use ($search) {
                            $q->whereHas('user', function ($user) use ($search) {
                                $user->where('username', 'like', "%$search%");
                            })->orWhereHas('company', function ($question) use ($search) {
                                $question->where('name', 'like', "%$search%");
                            });
                        });
            $this->pageTitle    = "Search Result for '$search'";
        }
        return $reviews->with('company', 'user')->latest()->paginate(getPaginate());
    }

    public function delete(Request $request)
    {
      
        $request->validate(
            [
                'review_id' => 'required|integer|exists:reviews,id',
                'company_id' => 'required|integer|exists:companies,id'
            ]
        );
        $review =  Review::where('id', $request->review_id)->where('company_id', $request->company_id)->firstOrFail();
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

    public function trdelete(Request $request)
    {
       
        $request->validate(
            [
                'review_id' => 'required|integer|exists:reviews,id',
                'company_id' => 'required|integer|exists:teachers,id'
            ]
        );
        // dd($request->review_id); 
        $review =  TeacherReview::where('id', $request->review_id)->where('teacher_id', $request->company_id)->firstOrFail();
        
        $company    = Teacher::find($review->teacher_id);
       
        // $review->delete();
        TeacherReview::destroy($request->review_id);
        $reviews = TeacherReview::where('teacher_id', $company->id)->get(['rating']);
        $company->avg_rating = 0;
        if ($reviews->count()) {
            $company->avg_rating = $reviews->sum('rating')  / $reviews->count();
        }
        $company->save();
        $notify[] = ['success', 'Successfully review deleted'];
        return back()->withNotify($notify);
    } 
}

