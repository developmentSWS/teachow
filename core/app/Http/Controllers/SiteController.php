<?php

namespace App\Http\Controllers;
use App\Models\AdminNotification;
use App\Models\Advertisement;
use App\Models\Category;
use App\Models\Company;
use App\Models\Frontend;
use App\Models\Language;
use App\Models\Page;
use App\Models\Review;
use App\Models\SupportMessage;
use App\Models\SupportTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Teacher;
use App\Models\TeacherReview;

class SiteController extends Controller
{
    public function __construct()
    {
        $this->activeTemplate = activeTemplate();
    }

    public function index()
    {
        $count = Page::where('tempname', $this->activeTemplate)->where('slug', 'home')->count();
        if ($count == 0) {
            $page = new Page();
            $page->tempname = $this->activeTemplate;
            $page->name = 'HOME';
            $page->slug = 'home';
            $page->save();
        }

        $reference = @$_GET['reference'];
        if ($reference) {
            session()->put('reference', $reference);
        }

        $pageTitle = 'Home';
        $sections = Page::where('tempname', $this->activeTemplate)->where('slug', 'home')->first();
        return view($this->activeTemplate . 'home', compact('pageTitle', 'sections'));
    }


    public function pages($slug)
    {
        $page = Page::where('tempname', $this->activeTemplate)->where('slug', $slug)->firstOrFail();
        $pageTitle = $page->name;
        $sections = $page->secs;
        return view($this->activeTemplate . 'pages', compact('pageTitle', 'sections'));
    }


    public function contact()
    {
        $pageTitle = "Contact Us";
        $sections = Page::where('tempname', $this->activeTemplate)->where('slug', 'contact')->first();
        return view($this->activeTemplate . 'contact', compact('pageTitle', 'sections'));
    }


    public function contactSubmit(Request $request)
    {
        $attachments = $request->file('attachments');
        $allowedExts = array('jpg', 'png', 'jpeg', 'pdf');

        $this->validate($request, [
            'name'    => 'required|max:191',
            'email'   => 'required|max:191',
            'subject' => 'required|max:100',
            'message' => 'required',
        ]);
        $random = getNumber();

        $ticket = new SupportTicket();
        $ticket->user_id = auth()->id() ?? 0;
        $ticket->name = $request->name;
        $ticket->email = $request->email;
        $ticket->priority = 2;

        $ticket->ticket = $random;
        $ticket->subject = $request->subject;
        $ticket->last_reply = now();
        $ticket->status = 0;
        $ticket->save();

        $adminNotification = new AdminNotification();
        $adminNotification->user_id = auth()->user() ? auth()->user()->id : 0;
        $adminNotification->title = 'A new support ticket has opened ';
        $adminNotification->click_url = urlPath('admin.ticket.view', $ticket->id);
        $adminNotification->save();

        $message = new SupportMessage();
        $message->supportticket_id = $ticket->id;
        $message->message = $request->message;
        $message->save();
        $notify[] = ['success', 'ticket created successfully!'];

        return redirect()->route('ticket.view', [$ticket->ticket])->withNotify($notify);
    }

    public function changeLanguage($lang = null)
    {
        $language = Language::where('code', $lang)->first();
        if (!$language) $lang = 'en';
        session()->put('lang', $lang);
        return redirect()->back();
    }

    public function blogs()
    {
        $pageTitle = 'Blogs';
        $emptyMessage = 'No Blog Yet';
        $blogs = Frontend::where('data_keys', 'blog.element')->latest()->paginate(getPaginate());
        $latest = Frontend::latest()->where('data_keys', 'blog.element')->limit(10)->get();
        $sections = Page::where('tempname', $this->activeTemplate)->where('slug', 'blog')->first();
        return view($this->activeTemplate . 'blog', compact('blogs', 'latest', 'pageTitle', 'emptyMessage', 'sections'));
    }

    public function blogDetails($id, $slug)
    {
        $blog       = Frontend::where('id', $id)->where('data_keys', 'blog.element')->firstOrFail();
        $pageTitle  = 'Blog Details';
        $latestPosts     = Frontend::latest()->where('data_keys', 'blog.element')->where('id', '!=', $id)->limit(10)->get();
        return view($this->activeTemplate . 'blog_details', compact('blog', 'pageTitle', 'latestPosts'));
    }

    public function cookieAccept()
    {
        session()->put('cookie_accepted', true);
        return back();
    }

    public function placeholderImage($size = null)
    {
        $imgWidth = explode('x', $size)[0];
        $imgHeight = explode('x', $size)[1];
        $text = $imgWidth . '×' . $imgHeight;
        $fontFile = realpath('assets/font') . DIRECTORY_SEPARATOR . 'RobotoMono-Regular.ttf';
        $fontSize = round(($imgWidth - 50) / 8);
        if ($fontSize <= 9) {
            $fontSize = 9;
        }
        if ($imgHeight < 100 && $fontSize > 30) {
            $fontSize = 30;
        }

        $image     = imagecreatetruecolor($imgWidth, $imgHeight);
        $colorFill = imagecolorallocate($image, 100, 100, 100);
        $bgFill    = imagecolorallocate($image, 175, 175, 175);
        imagefill($image, 0, 0, $bgFill);
        $textBox = imagettfbbox($fontSize, 0, $fontFile, $text);
        $textWidth  = abs($textBox[4] - $textBox[0]);
        $textHeight = abs($textBox[5] - $textBox[1]);
        $textX      = ($imgWidth - $textWidth) / 2;
        $textY      = ($imgHeight + $textHeight) / 2;
        header('Content-Type: image/jpeg');
        imagettftext($image, $fontSize, 0, $textX, $textY, $colorFill, $fontFile, $text);
        imagejpeg($image);
        imagedestroy($image);
    }

    public function policyPage($slug, $id)
    {
        $policyPage    = Frontend::where('id', $id)->where('data_keys', 'policy_pages.element')->firstOrFail();
        $pageTitle = $policyPage->data_values->title;
        return view($this->activeTemplate . 'policy_page', compact('policyPage', 'pageTitle'));
    }

    public function searchFromBanner(Request $request)
    {
        if($request->for == "institution")
        {
            $pageTitle = "Search Institute";
            $emptyMessage = "No $request->search, data found";
            $categories = Category::where('status', 1)->with('company')->whereHas('company', function ($q) {
                $q->approved();
            })->get();
    
            $companies = Company::approved()->with('category')->where('name', 'like', "%$request->search%")
                ->orWhereJsonContains('tags', $request->search)
                ->orWhereHas('category', function ($q) use ($request) {
                    $q->where('name', $request->search);
                })->latest()->withAvg('reviews', 'rating')->withCount('reviews')->paginate(getPaginate());

                return view($this->activeTemplate . 'company.index', compact('pageTitle', 'categories', 'companies', 'emptyMessage'));
        }else if($request->for == "teacher")
        {
            $pageTitle = "Search Teacher";
            $emptyMessage = "No $request->search, data found";
    
            $companies = Teacher::approved()->where('name', 'like', "%$request->search%")
                ->orWhereJsonContains('tags', $request->search)
                ->latest()->withAvg('treviews', 'rating')->withCount('treviews')->paginate(getPaginate());

                return view($this->activeTemplate . 'company.index1', compact('pageTitle', 'companies', 'emptyMessage'));

        }else {
            $notify[] = "Please Select Institute or Teacher Correctly";
            return back()->withNotify($notify);
        }
       
        $notify[] = "Please Select Institute or Teacher Correctly";
        return back()->withNotify($notify);
        
    }

    public function searchFromBanner1(Request $request)
    {
        $pageTitle = "Search Teacher";
        $emptyMessage = "No $request->search, data found";
        $categories = Category::where('status', 1)->with('company')->whereHas('company', function ($q) {
            $q->approved();
        })->get();

        $Institute = Company::approved()->with('category')->where('name', 'like', "%$request->search%")
            ->orWhereJsonContains('tags', $request->search)
            ->orWhereHas('category', function ($q) use ($request) {
                $q->where('name', $request->search);
            })->latest()->withAvg('reviews', 'rating')->withCount('reviews')->paginate(getPaginate());

        return view($this->activeTemplate . 'company.index', compact('pageTitle', 'categories', 'companies', 'emptyMessage'));
    }

    public function companies($id=null)
    {
        $companies      = Company::approved();
        $categories     = Category::where('status', 1);
        $pageTitle      = 'All Institute';

        if($id){
            $companies->where('category_id', $id);
            $category     = Category::where('id', $id)->firstOrFail();
            $categories   = $categories->where('id', $id);
            $pageTitle    = $category->name .' Institute';
        }

        $categories     = $categories->with('company')->whereHas('company', function ($q) {
            $q->approved();
        })->get();


        $companies = $companies->withAvg('reviews', 'rating')->withCount('reviews')->with('category')->latest()->paginate(getPaginate());
        $emptyMessage   = "No Institute yet";
        return view($this->activeTemplate . 'company.index', compact('pageTitle', 'companies', 'categories',  'emptyMessage'));
    }

    public function companies1($id=null)
    {
        $companies      = Teacher::approved();
        $pageTitle      = 'All Teacher';

        $companies = $companies->withAvg('treviews', 'rating')->withCount('treviews')->latest()->paginate(getPaginate());

        $emptyMessage   = "No teacher yet";
        return view($this->activeTemplate . 'company.index1', compact('pageTitle', 'companies',  'emptyMessage'));
    }


    public function filterCompanies(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_id'   => 'nullable|exists:categories,id',
            'rating'        => 'nullable|min:1|max:5',
            'review_time'   => 'nullable|integer',
            'reg_start'     => 'nullable|integer',
            'reg_end'       => 'nullable|integer'
        ]);

        $query = Company::approved()->with('category')->withAvg('reviews', 'rating')->withCount('reviews');

        if ($request->search_key) {
            $query = $query->where('name', 'like', "%$request->search_key%")->orWhere('tags', 'like', "%$request->search_key%")->orWhereHas('category', function ($q) use ($request) {
                $q->where('name', $request->search_key);
            });
        }

        if ($request->category_id) {
            $query = $query->where('category_id', $request->category_id);
        }

        if ($request->rating) {
            $query = $query->whereBetween('avg_rating', [$request->rating - 1 + .1, $request->rating]);
        }

        if ($request->review_time) {
            $startMonth = now()->subMonths($request->review);
            $endMonth =  now();

            $query = $query->whereHas('reviews', function ($q) use ($startMonth, $endMonth) {
                $q->whereBetween('created_at', [$startMonth, $endMonth]);
            });
        }

        if ($request->reg_start && $request->reg_end) {
            $start = now()->subYear($request->reg_end);
            $end   = now()->subYear($request->reg_start);
            $query = $query->whereBetween('created_at', [$start, $end]);
        } elseif ($request->reg_end) {
            $start = now()->subYear($request->reg_end);
            $end   = now();
            $query = $query->whereBetween('created_at', [$start, $end]);
        } elseif ($request->reg_start) {
            $year = now()->subYear($request->reg_start);
            $query = $query->whereDate('created_at', '<', $year);
        } else {
            $query = $query;
        }


        $companies  = $query->latest()->with('category')->paginate(getPaginate());

        $emptyMessage = "No Institute found";

        $categories   = Category::where('status', 1)->with('company')->whereHas('company', function ($q) {
            $q->approved();
        })->get();

        return view($this->activeTemplate . 'company.companies', compact('categories', 'companies', 'emptyMessage'));
    }

    public function filterCompanies1(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'rating'        => 'nullable|min:1|max:5',
            'review_time'   => 'nullable|integer',
            'reg_start'     => 'nullable|integer',
            'reg_end'       => 'nullable|integer'
        ]);

        $query = Teacher::approved()->withAvg('treviews', 'rating')->withCount('treviews');

        if ($request->search_key) {
            $query = $query->where('name', 'like', "%$request->search_key%")->orWhere('tags', 'like', "%$request->search_key%");
        }

        if ($request->rating) {
            $query = $query->whereBetween('avg_rating', [$request->rating - 1 + .1, $request->rating]);
        }

        if ($request->review_time) {
            $startMonth = now()->subMonths($request->review);
            $endMonth =  now();

            $query = $query->whereHas('treviews', function ($q) use ($startMonth, $endMonth) {
                $q->whereBetween('created_at', [$startMonth, $endMonth]);
            });
        }

        if ($request->reg_start && $request->reg_end) {
            $start = now()->subYear($request->reg_end);
            $end   = now()->subYear($request->reg_start);
            $query = $query->whereBetween('created_at', [$start, $end]);
        } elseif ($request->reg_end) {
            $start = now()->subYear($request->reg_end);
            $end   = now();
            $query = $query->whereBetween('created_at', [$start, $end]);
        } elseif ($request->reg_start) {
            $year = now()->subYear($request->reg_start);
            $query = $query->whereDate('created_at', '<', $year);
        } else {
            $query = $query;
        }


        $companies  = $query->latest()->paginate(getPaginate());

        $emptyMessage = "No Teacher found";

        return view($this->activeTemplate . 'teacher.teacher', compact('companies', 'emptyMessage'));
    }


    public function companyDetails(Request $request, $id, $slug)
    {
        $pageTitle = 'Institute Details';
        $emptyMessage = "No review yet";
        $company = Company::approved()->where('id', $id)->withAvg('reviews', 'rating')->withCount('reviews')->firstOrFail();
        $instituteTeacher = Teacher::where('institute', $id)->get();
        $reviews = Review::where('user_id', '!=', auth()->id())->with('user','company')->where('company_id', $id)->latest()->paginate(getPaginate(5));
        // dd($reviews);
        $myReview = Review::where('user_id', auth()->id())->where('company_id', $id)->latest()->first();

        return view($this->activeTemplate . 'company.details', compact('pageTitle', 'emptyMessage', 'company', 'reviews', 'myReview', 'instituteTeacher'));
    }


    public function companyDetails1(Request $request, $id, $slug)
    {
        $pageTitle = 'Teacher Details';
        $emptyMessage = "No review yet";
        $company = Teacher::approved()->where('id', $id)->withAvg('treviews', 'rating')->withCount('treviews')->firstOrFail();
        //  dd($company);
        $institute = explode(',', $company->institute);
        $instituteDetails = Company::approved()->whereIn('id', $institute)->get();
        $getinstituteNameArr = Company::approved()->whereIn('id', $institute)->pluck('name')->toArray();
        // dd($getinstituteNameArr);
        // similar Institutes
        // $similarInstitutes = Company::approved()->whereIn('name', 'LIKE', '%'.$getinstituteNameArr.'%')->get();
        $similarInstitutes = Company::approved()
        ->where(function ($query) use ($getinstituteNameArr) {
            foreach ($getinstituteNameArr as $instituteName) {
                $query->orWhere('name', 'LIKE', '%' . $instituteName . '%');
            }
        })->whereNotIn('id', $institute)->get();
        // dd($similarInstitutes);
        $otherteacher = Teacher::approved()->where('id', '!=', $id)->whereIn('institute', $institute)->get();
        $reviews = TeacherReview::where('user_id', '!=', auth()->id())->with('user','teacher')->where('teacher_id', $id)->latest()->paginate(getPaginate(5));
        $myReview = TeacherReview::where('user_id', auth()->id())->where('teacher_id', $id)->latest()->first();

        return view($this->activeTemplate . 'teacher.details', compact('pageTitle', 'instituteDetails', 'otherteacher', 'similarInstitutes', 'emptyMessage', 'company', 'reviews', 'myReview'));
    }
    
    public function testRating()
    {
        // dd($this->activeTemplate . 'testing');
        $pageTitle = 'Test Details';
        return view($this->activeTemplate . 'testing', compact('pageTitle'));
    }

    public function review(Request $request, $id)
    {
        $request->validate(
            [
                'rating' => 'required|integer|min:1|max:5',
                'teaching_faculty' => 'required|integer|min:1|max:5',
                'infra_quality' => 'required|integer|min:1|max:5',
                'technology_friendly' => 'required|integer|min:1|max:5',
                'counseling_quality' => 'required|integer|min:1|max:5',
                'operational_manage' => 'required|integer|min:1|max:5',
                'attitude_management' => 'required|integer|min:1|max:5',
                'quality_classroom' => 'required|integer|min:1|max:5',
                'tests' => 'required|integer|min:1|max:5',
                'quality_study' => 'required|integer|min:1|max:5',
                'current_affair' => 'required|integer|min:1|max:5',
                'interview_guidance' => 'required|integer|min:1|max:5',
                'review' => 'required|string',
            ]
        );
        $company = Company::approved()->findOrFail($id);
        $review = Review::where('company_id', $id)->where('user_id', auth()->id())->first();
        if (!$review) {
            $review = new Review();
        }
        $review->rating  = $request->rating;
        $review->teaching_faculty  = $request->teaching_faculty;
        $review->infra_quality  = $request->infra_quality;
        $review->technology_friendly  = $request->technology_friendly;
        $review->counseling_quality  = $request->counseling_quality;
        $review->operational_manage  = $request->operational_manage;
        $review->attitude_management  = $request->attitude_management;
        $review->quality_classroom  = $request->quality_classroom;
        $review->tests  = $request->tests;
        $review->quality_study  = $request->quality_study;
        $review->current_affair  = $request->current_affair;
        $review->interview_guidance  = $request->interview_guidance;
        $review->review  = $request->review;
        $review->user_id = auth()->id();
        $review->company_id = $id;
        $review->save();
        $reviews = Review::where('company_id', $id)->get();
        $company->avg_rating = $reviews->sum('rating') / $reviews->count();
        $company->save();
        $notify[] = ['success', 'Thanks for your review! Review the teachers as well'];
        return back()->withNotify($notify);
    }

    public function teacherReview(Request $request, $id)
    {
        $request->validate(
            [
                'rating' => 'required|integer|min:1|max:5',
                'friendliness_teaching' => 'required|integer|min:1|max:5',
                'clarity_of_concept' => 'required|integer|min:1|max:5',
                'clarity_of_concept' => 'required|integer|min:1|max:5',
                'student_engage' => 'required|integer|min:1|max:5',
                'punctuality' => 'required|integer|min:1|max:5',
                'content_validity' => 'required|integer|min:1|max:5',
                'syllabus_completed' => 'required|integer|min:1|max:5',
                'review' => 'required|string',
            ]
        );
        $company = Teacher::approved()->findOrFail($id);
        $review = TeacherReview::where('teacher_id', $id)->where('user_id', auth()->id())->first();
        if (!$review) {
            $review = new TeacherReview();
        }
        $review->rating  = $request->rating;
        $review->friendliness_teaching  = $request->friendliness_teaching;
        $review->clarity_of_concept  = $request->clarity_of_concept;
        $review->communication  = $request->communication;
        $review->student_engage  = $request->student_engage;
        $review->punctuality  = $request->punctuality;
        $review->content_validity  = $request->content_validity;
        $review->syllabus_completed  = $request->syllabus_completed;
        $review->review  = $request->review;
        $review->user_id = auth()->id();
        $review->teacher_id = $id;
        $review->institute_id = $company->institute;
        $review->save();
        $reviews = TeacherReview::where('teacher_id', $id)->get();
        $company->avg_rating = $reviews->sum('rating') / $reviews->count();
        $company->save();
        $notify[] = ['success', 'Yay! Rating is successfully submitted and will reflect on the website in a few minutes also Your voice matters! Thank you for helping others make the right choice.'];
        return back()->withNotify($notify);
    }

    public function addClick($id)
    {
        $advertisement = Advertisement::find($id);

        if($advertisement){
            $advertisement->click += 1;
            $advertisement->save();
        }
        return response()->json([
            'success' => true,
            'data' => $advertisement
        ]);
    }
}
