@extends($activeTemplate.'layouts.frontend')
@php
$content = getContent('breadcrumb.content', true);
@endphp
@section('content')
<section class="section--bg pb-100">
    <div class="company-details-bg bg_img d-lg-block d-none"
        style="background-image: url('{{ getImage('assets/images/frontend/breadcrumb/' . @$content->data_values->image, '1920x840') }}');">
    </div>
    <div class="company-details-header">
        <div class="container">
            <div class="row justify-content-end">
                <div class="col-lg-8 ps-xxl-5">
                    <div class="row gy-4">
                        <div class="col-md-8 text-md-start text-center">
                            <div class="company-profile">
                                <h3 class="company-profile__name">{{ $company->name }}</h3>
                                <span><i class="las la-user"></i>{{ $company->address }}</span>  <br>
                                <span><i class="las la-map-marker"></i>{{ $company->location }}</span>   <br>
                                @php $Institute = explode(',', $company->institute);
                                    $getInstituteName = App\Models\Company::whereIn('id', $Institute)->pluck('name')->toArray();
                                @endphp
                                @if(!empty($getInstituteName))
                                    <span><i class="las la-building"></i>
                                        @forelse($getInstituteName as $getInstituteN)
                                            {{ $getInstituteN }} &nbsp;
                                        @empty
                                        @endforelse
                                        @if(in_array('kk', $Institute))    
                                            {{ ('Other') }}
                                        @endif
                                        @if(in_array('mm', $Institute))    
                                            {{ ('Free Lancer') }}
                                        @endif
                                        
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="company-website section--bg2 text-center has--link">
                                @php $alreadyClaim = App\Models\Claim::latest()->where('user_id', auth()->id())->where('t_i_id',
                                $company->id)->where('status', 1)->first(); @endphp
                                @if(empty($alreadyClaim))
                                <a href="{{ route('user.claimTeacherProfile', ['id' => $company->id]) }}"
                                    class="item--link"></a>
                                <h6 class="fs--16px text-white"><i class="las la-external-link-alt"></i></h6>
                                <span class="fs--12px text-white">@lang('Claim This Teacher')</span>
                                @else
                                <h6 class="fs--16px text-white"><i class="las la-external-link-alt"></i></h6>
                                <span class="fs--12px text-white">@lang('Already Claimed')</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <div class="company-sidebar">
                    <div class="row gy-5">
                        <div class="company-sidebar__widget col-lg-12 col-md-5">
                            <div class="company-overview">
                                <div class="company-overview__thumb">
                                    <img src="{{ getImage(imagePath()['company']['path'] . '/' . $company->image) }}"
                                        alt="image">
                                </div>
                            </div>
                        </div><!-- company-sidebar__widget end -->
                        <div class="company-sidebar__widget col-lg-12 col-md-7">
                            <div class="rating-area d-flex flex-wrap align-items-center justify-content-between mb-4">
                                <div class="rating">{{ showAmount(@$company->avg_rating) }}</div>
                                <div class="content">
                                    <div class="ratings d-flex align-items-center justify-content-end fs--18px">
                                        @php
                                        echo avgRating($company->avg_rating);
                                        @endphp
                                    </div>
                                    <span class="mt-1 text-muted fs--14px">@lang('Based on')
                                        {{ @$company->treviews_count }} @lang('Reviews')</span>
                                </div>
                            </div>

                            @for ($i = 5; $i >= 1; $i--)
                            @php
                            $reviewCount = $company->treviews->where('rating', $i)->count();
                            $percentage = 0;
                            if ($reviewCount) {
                            $percentage = ($reviewCount / $company->treviews_count) * 100;
                            }
                            @endphp

                            <div class="single-review">
                                <p class="star">{{ $i }} <i class="las la-star text--base"></i>
                                </p>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" style="width: {{ $percentage }}%"
                                        aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <span class="percentage">{{ showAmount($percentage) }}%</span>
                            </div>
                            @endfor
                        </div>

                        <div class="company-sidebar__widget col-lg-12">
                            <div class="single-company-info">
                                <h5 class="single-company-info__title">@lang('Ratings') </h5>
                            </div>
                            @php
                            $CompanyReviewCount = $company->treviews->count();
                            if($CompanyReviewCount > 0) {
                            $teaching_faculty = $company->treviews->sum('friendliness_teaching') / $CompanyReviewCount;
                            $infra_quality = $company->treviews->sum('clarity_of_concept') / $CompanyReviewCount;
                            $technology_friendly = $company->treviews->sum('communication') / $CompanyReviewCount;
                            $counseling_quality = $company->treviews->sum('student_engage') / $CompanyReviewCount;
                            $operational_manage = $company->treviews->sum('punctuality') / $CompanyReviewCount;
                            $attitude_management = $company->treviews->sum('content_validity') / $CompanyReviewCount;
                            $quality_classroom = $company->treviews->sum('syllabus_completed') / $CompanyReviewCount;
                            }else {
                            $teaching_faculty = 0;
                            $infra_quality = 0;
                            $technology_friendly = 0;
                            $counseling_quality = 0;
                            $operational_manage = 0;
                            $attitude_management = 0;
                            $quality_classroom = 0;
                            }
                            @endphp

                            <div class="ag-format-container">
                                <ul class="mt-3">
                                    <li title="Friendliness of teaching pedagogy (Positive teaching-learning environment in class)"> <b>Friendliness of teaching pedagogy</b> <br>
                                    <p>  {{ showAmount($teaching_faculty) }}  (
                                            @php
                                                echo avgRating($teaching_faculty);
                                            @endphp) 
                                    </p>
                                    </li> 
                                    <hr>
                                    <li title="Clarity of concepts taught (capacity to simplify complex concepts and explain them)."> <b>Clarity of concepts taught</b> <br>
                                    <p>  {{ showAmount($infra_quality) }}  (
                                             @php
                                                        echo avgRating($infra_quality);
                                                        @endphp) 
                                    </p>
                                    </li> <hr>
                                    <li title="Communication Skills - command and fluency over teaching language"> <b>Communication Skills</b> <br>
                                    <p>  {{ showAmount($technology_friendly) }}  (
                                             @php
                                                        echo avgRating($technology_friendly);
                                                        @endphp) 
                                    </p>
                                    </li> <hr>
                                    <li title="Student engagement in class/attention to doubt solving"> <b>Student engagement in class</b> <br>
                                    <p>  {{ showAmount($counseling_quality) }}  (
                                             @php
                                                        echo avgRating($counseling_quality);
                                                        @endphp) 
                                    </p>
                                    </li> <hr>
                                    <li title="Punctuality"> <b>Punctuality</b> <br>
                                    <p>  {{ showAmount($operational_manage) }}  (
                                             @php
                                                        echo avgRating($operational_manage);
                                                        @endphp) 
                                    </p>
                                    </li> <hr>
                                    <li title="Content validity : Previous year questions discussed and/or solvable through class teaching (* except questions related to current affairs - previous year's questions may not be very valid for the current year )"> <b>Content validity</b> <br>
                                    <p>  {{ showAmount($attitude_management) }}  (
                                             @php
                                                        echo avgRating($attitude_management);
                                                        @endphp) 
                                    </p>
                                    </li> <hr>
                                     <li title="Syllabus completed as per communicated commitment at the start of the course"> <b> Syllabus completed</b> <br>
                                    <p>  {{ showAmount($quality_classroom) }}  (
                                             @php
                                                        echo avgRating($quality_classroom);
                                                        @endphp) 
                                    </p>
                                    </li> <hr>
                                    
                                    
                                </ul>
                              
                            </div>
                        </div>

                        <div class="company-sidebar__widget col-lg-12">
                            <div class="single-company-info">
                                <h5 class="single-company-info__title">@lang('About') {{ __($company->name) }}</h5>
                                <p class="mt-2">
                                    {{ __(@$company->description) }}
                                </p>
                            </div>
                            <div class="single-company-info">
                                <h5 class="single-company-info__title">@lang('Tags')</h5>
                                <div class=" mt-3">
                                    @if(!empty($company->tags))
                                    @foreach (@$company->tags as $tag)
                                    {{ $tag }}
                                    @if (!$loop->last)
                                    ,
                                    @endif
                                    @endforeach
                                    @endif
                                </div>
                            </div>
                            <div class="single-company-info">
                                <h5 class="single-company-info__title">@lang(' Info')</h5>
                                <ul class="single-company-info__list">

                                    <li>
                                        <div class="icon"><i class="las la-user"></i></div>
                                        <div class="content">
                                            <p>{{ __(@$company->address) }}</p>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="icon"><i class="las la-envelope"></i></div>
                                        <div class="content"><a
                                                href="mailto:{{ @$company->email }}">{{ @$company->email }}</a>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        {{-- Advertisement --}}
                        <div class="has--link mt-4">
                            @php
                            echo getAdvertisement('300x250');
                            @endphp
                        </div>

                    </div><!-- row end -->
                </div>
            </div>
            <div class="col-lg-8 ps-xxl-5 mt-5">
                @auth
                @if(!$myReview)
                <div class="give-rating-area mb-5">
                    <form action="{{ route('user.teacher.review', $company->id) }}" method="post">
                        @csrf
                        <div class="give-rating-person">
                            <div class="thumb">
                                <img src="{{ getImage(imagePath()['profile']['user']['path'] . '/' . auth()->user()->image, null, true) }}"
                                    alt="image">
                            </div>
                            <div class="content">
                                <h6>{{ auth()->user()->fullname }}</h6>
                            </div>


                        </div>
                        <div class="row mt-4">
                            <div class="col-sm-12">
                                <div class="card" style="height: 150px;">
                                    <div class="card-header text-center"> Overall - </div>
                                    <div class="card-body"
                                        style="display: flex; justify-content: center; align-items:center;">
                                        <div class='give-rating'>
                                            @for ($i = 5; $i >= 1; $i--)
                                            <span>
                                                <input id='str{{ $i }}' name='rating' type='radio' value='{{ $i }}'>
                                                <label for='str{{ $i }}'><i class="las la-star fa-sm"></i></label>
                                            </span>
                                            @endfor

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 mt-3">
                                <div class="card" style="height: 200px;">
                                    <div class="card-header text-center"
                                        style="height: 100px; display: flex; justify-content: center; align-items: center;">
                                        Friendliness of teaching pedagogy (Positive teaching-learning environment in
                                        class)</div>
                                    <div class="card-body"
                                        style="display: flex; justify-content: center; align-items:center;">
                                        <div class='give-rating'>
                                            @for ($i = 5; $i >= 1; $i--)
                                            <span>
                                                <input id='str1{{ $i }}' name='friendliness_teaching' type='radio'
                                                    value='{{ $i }}'>
                                                <label for='str1{{ $i }}'><i class="las la-star fa-sm"></i></label>
                                            </span>
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 mt-3">
                                <div class="card" style="height: 200px;">
                                    <div class="card-header text-center"
                                        style="height: 100px; display: flex; justify-content: center; align-items: center;">
                                        Clarity of concept taught (capacity to simplify complex concepts and explain
                                        them)</div>
                                    <div class="card-body"
                                        style="display: flex; justify-content: center; align-items:center;">
                                        <div class='give-rating'>
                                            @for ($i = 5; $i >= 1; $i--)
                                            <span>
                                                <input id='str2{{ $i }}' name='clarity_of_concept' type='radio'
                                                    value='{{ $i }}'>
                                                <label for='str2{{ $i }}'><i class="las la-star fa-sm"></i></label>
                                            </span>
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 mt-3">
                                <div class="card" style="height: 200px;">
                                    <div class="card-header text-center"
                                        style="height: 100px; display: flex; justify-content: center; align-items: center;">
                                        Communication Skills - command and fluency over teaching language </div>
                                    <div class="card-body"
                                        style="display: flex; justify-content: center; align-items:center;">
                                        <div class='give-rating'>
                                            @for ($i = 5; $i >= 1; $i--)
                                            <span>
                                                <input id='str3{{ $i }}' name='communication' type='radio'
                                                    value='{{ $i }}'>
                                                <label for='str3{{ $i }}'><i class="las la-star fa-sm"></i></label>
                                            </span>
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 mt-3">
                                <div class="card" style="height: 200px;">
                                    <div class="card-header text-center"
                                        style="height: 100px; display: flex; justify-content: center; align-items: center;">
                                        Student engagement in class/attention to doubt solving </div>
                                    <div class="card-body"
                                        style="display: flex; justify-content: center; align-items:center;">
                                        <div class='give-rating'>
                                            @for ($i = 5; $i >= 1; $i--)
                                            <span>
                                                <input id='str4{{ $i }}' name='student_engage' type='radio'
                                                    value='{{ $i }}'>
                                                <label for='str4{{ $i }}'><i class="las la-star fa-sm"></i></label>
                                            </span>
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 mt-3">
                                <div class="card" style="height: 200px;">
                                    <div class="card-header text-center"
                                        style="height: 70px; display: flex; justify-content: center; align-items: center;">
                                        Punctuality</div>
                                    <div class="card-body"
                                        style="display: flex; justify-content: center; align-items:center;">
                                        <div class='give-rating'>
                                            @for ($i = 5; $i >= 1; $i--)
                                            <span>
                                                <input id='str5{{ $i }}' name='punctuality' type='radio'
                                                    value='{{ $i }}'>
                                                <label for='str5{{ $i }}'><i class="las la-star fa-sm"></i></label>
                                            </span>
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 mt-3">
                                <div class="card" style="height: 200px;">
                                    <div class="card-header text-center"> Syllabus completed as per communicated
                                        commitment at the start of the course - </div>
                                    <div class="card-body"
                                        style="display: flex; justify-content: center; align-items:center;">
                                        <div class='give-rating'>
                                            @for ($i = 5; $i >= 1; $i--)
                                            <span>
                                                <input id='str6{{ $i }}' name='syllabus_completed' type='radio'
                                                    value='{{ $i }}'>
                                                <label for='str6{{ $i }}'><i class="las la-star fa-sm"></i></label>
                                            </span>
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-3">
                                <div class="card" style="height: 200px;">
                                    <div class="card-header text-center"> Content validity : Previous year questions
                                        and/or solvable through class teaching (* except questions related to current
                                        affairs - previous year's questions may not be very valid for the current year )
                                    </div>
                                    <div class="card-body"
                                        style="display: flex; justify-content: center; align-items:center;">
                                        <div class='give-rating'>
                                            @for ($i = 5; $i >= 1; $i--)
                                            <span>
                                                <input id='str7{{ $i }}' name='content_validity' type='radio'
                                                    value='{{ $i }}'>
                                                <label for='str7{{ $i }}'><i class="las la-star fa-sm"></i></label>
                                            </span>
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <textarea name="review" class="form--control" placeholder="@lang('Write review')"
                                required>{{ old('review') }}</textarea>
                            <div class="text-end">
                                <button type="submit" class="btn btn--base">@lang('Submit')</button>
                            </div>
                        </div>
                    </form>
                </div>
                @endif
                @else
                <h3 class="text-center m-3">Write Your Review</h3>
                <div class="row mt-4">
                            <div class="col-sm-12">
                                <div class="card" style="height: 150px;">
                                    <div class="card-header text-center"> Overall - </div>
                                    <div class="card-body"
                                        style="display: flex; justify-content: center; align-items:center;">
                                        <div class='give-rating'>
                                            @for ($i = 5; $i >= 1; $i--)
                                            <span>
                                                <input id='str{{ $i }}' name='rating' type='radio' data-bs-toggle="modal" data-bs-target="#loginModal" value='{{ $i }}'>
                                                <label for='str{{ $i }}'><i class="las la-star fa-sm"></i></label>
                                            </span>
                                            @endfor

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 mt-3">
                                <div class="card" style="height: 200px;">
                                    <div class="card-header text-center"
                                        style="height: 100px; display: flex; justify-content: center; align-items: center;">
                                        Friendliness of teaching pedagogy (Positive teaching-learning environment in
                                        class)</div>
                                    <div class="card-body"
                                        style="display: flex; justify-content: center; align-items:center;">
                                        <div class='give-rating'>
                                            @for ($i = 5; $i >= 1; $i--)
                                            <span>
                                                <input id='str1{{ $i }}' name='friendliness_teaching' data-bs-toggle="modal" data-bs-target="#loginModal" type='radio'
                                                    value='{{ $i }}'>
                                                <label for='str1{{ $i }}'><i class="las la-star fa-sm"></i></label>
                                            </span>
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 mt-3">
                                <div class="card" style="height: 200px;">
                                    <div class="card-header text-center"
                                        style="height: 100px; display: flex; justify-content: center; align-items: center;">
                                        Clarity of concept taught (capacity to simplify complex concepts and explain
                                        them)</div>
                                    <div class="card-body"
                                        style="display: flex; justify-content: center; align-items:center;">
                                        <div class='give-rating'>
                                            @for ($i = 5; $i >= 1; $i--)
                                            <span>
                                                <input id='str2{{ $i }}' name='clarity_of_concept' data-bs-toggle="modal" data-bs-target="#loginModal" type='radio'
                                                    value='{{ $i }}'>
                                                <label for='str2{{ $i }}'><i class="las la-star fa-sm"></i></label>
                                            </span>
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 mt-3">
                                <div class="card" style="height: 200px;">
                                    <div class="card-header text-center"
                                        style="height: 100px; display: flex; justify-content: center; align-items: center;">
                                        Communication Skills - command and fluency over teaching language </div>
                                    <div class="card-body"
                                        style="display: flex; justify-content: center; align-items:center;">
                                        <div class='give-rating'>
                                            @for ($i = 5; $i >= 1; $i--)
                                            <span>
                                                <input id='str3{{ $i }}' name='communication' data-bs-toggle="modal" data-bs-target="#loginModal" type='radio'
                                                    value='{{ $i }}'>
                                                <label for='str3{{ $i }}'><i class="las la-star fa-sm"></i></label>
                                            </span>
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 mt-3">
                                <div class="card" style="height: 200px;">
                                    <div class="card-header text-center"
                                        style="height: 100px; display: flex; justify-content: center; align-items: center;">
                                        Student engagement in class/attention to doubt solving </div>
                                    <div class="card-body"
                                        style="display: flex; justify-content: center; align-items:center;">
                                        <div class='give-rating'>
                                            @for ($i = 5; $i >= 1; $i--)
                                            <span>
                                                <input id='str4{{ $i }}' name='student_engage' data-bs-toggle="modal" data-bs-target="#loginModal" type='radio'
                                                    value='{{ $i }}'>
                                                <label for='str4{{ $i }}'><i class="las la-star fa-sm"></i></label>
                                            </span>
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 mt-3">
                                <div class="card" style="height: 200px;">
                                    <div class="card-header text-center"
                                        style="height: 70px; display: flex; justify-content: center; align-items: center;">
                                        Punctuality</div>
                                    <div class="card-body"
                                        style="display: flex; justify-content: center; align-items:center;">
                                        <div class='give-rating'>
                                            @for ($i = 5; $i >= 1; $i--)
                                            <span>
                                                <input id='str5{{ $i }}' name='punctuality' data-bs-toggle="modal" data-bs-target="#loginModal" type='radio'
                                                    value='{{ $i }}'>
                                                <label for='str5{{ $i }}'><i class="las la-star fa-sm"></i></label>
                                            </span>
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 mt-3">
                                <div class="card" style="height: 200px;">
                                    <div class="card-header text-center"> Syllabus completed as per communicated
                                        commitment at the start of the course - </div>
                                    <div class="card-body"
                                        style="display: flex; justify-content: center; align-items:center;">
                                        <div class='give-rating'>
                                            @for ($i = 5; $i >= 1; $i--)
                                            <span>
                                                <input id='str6{{ $i }}' name='syllabus_completed' data-bs-toggle="modal" data-bs-target="#loginModal" type='radio'
                                                    value='{{ $i }}'>
                                                <label for='str6{{ $i }}'><i class="las la-star fa-sm"></i></label>
                                            </span>
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-3">
                                <div class="card" style="height: 200px;">
                                    <div class="card-header text-center"> Content validity : Previous year questions
                                        and/or solvable through class teaching (* except questions related to current
                                        affairs - previous year's questions may not be very valid for the current year )
                                    </div>
                                    <div class="card-body"
                                        style="display: flex; justify-content: center; align-items:center;">
                                        <div class='give-rating'>
                                            @for ($i = 5; $i >= 1; $i--)
                                            <span>
                                                <input id='str7{{ $i }}' name='content_validity' data-bs-toggle="modal" data-bs-target="#loginModal" type='radio'
                                                    value='{{ $i }}'>
                                                <label for='str7{{ $i }}'><i class="las la-star fa-sm"></i></label>
                                            </span>
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                <!-- <div class="give-rating-area mb-5">
                    <p class="text-center">@lang('You need to')
                        <a href="{{ route('user.login') }}" class="text--base">@lang('Login')</a> @lang(' first to
                        submit your review.')
                    </p>
                </div> -->
                @endauth
                <div class="customer-review-wrapper">
                    @include($activeTemplate . 'partials.teacher_review')
                </div>

                <div class="customer-review-wrapper mt-5 mb-5">
                    <h3 class="text-center">Rate Other Teacher's at 
                    
                        @if(!empty($getInstituteName))
                                  
                                        @forelse($getInstituteName as $getInstituteN)
                                            {{ $getInstituteN }} &nbsp;
                                        @empty
                                        @endforelse
                                        @if(in_array('kk', $Institute))    
                                            {{ ('Other') }}
                                        @endif
                                        @if(in_array('mm', $Institute))    
                                            {{ ('Free Lancer') }}
                                        @endif
                                        
                                    </span>
                                @endif
                    </h3>
                    <div class="row">
                        @forelse ($otherteacher as $k => $company1)
                        <div class="col-lg-6 mt-3">
                            <div class="company-review has--link">
                                <a href="{{ route('teacher.details', [$company1->id, slug($company1->name)]) }}"
                                    class="item--link"></a>
                                <div class="company-review__top">
                                    <div class="thumb">
                                        <img src="{{ getImage(imagePath()['company']['path'] . '/' . @$company1->image) }}"
                                            alt="company logo">
                                        @if ($company1->user_id == auth()->id())
                                        <span class="auth-company">
                                            <i class="la la-user" aria-hidden="true"></i>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="content">
                                        <div class="company-review__name d-flex flex-wrap justify-content-between">
                                            <div class="left-side">
                                                <h6>
                                                    <a
                                                        href="{{ route('teacher.details', [$company1->id, slug($company1->name)]) }}">{{ @$company1->name }}</a>
                                                </h6>

                                            </div>
                                            <div class="text-right text--base">
                                                @php echo avgRating($company1->avg_rating); @endphp
                                                <p class="fs--14px text-muted"> &nbsp; {{ $company1->avg_rating }}
                                                    ({{ @$company1->reviews_count }}
                                                    @lang('ratings'))
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <span class="fs--14px mt-2 lh-1"><i class="las la-map-marker"></i>
                                        {{ @$company1->address }}</span>
                                </div>
                                <div class="company-review__ratings mt-3 text--base">
                                    <div class="d-flex justify-content-between">
                                        <span class="fs--14px text-muted d-block">@lang('Registered On') :
                                            {{ showDateTime($company1->created_at, 'd M Y') }}</span>
                                    </div>
                                </div>
                                <div class="company-review__tags mt-2">
                                    @if(!empty($company1->tags))
                                    @foreach (@$company1->tags as $tag)
                                    {{ $tag }}
                                    {{ !$loop->last ? ', ' : null }}
                                    @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="review-block">
                            <div class="customer-reviewdd">
                                <div class="d-flex justify-content-center">
                                    <h5> {{ __($emptyMessage) }}</h5>
                                </div>
                            </div>
                        </div>
                        @endforelse
                    </div>
                </div>

                <div class="customer-review-wrapper mt-5 mb-5">
                    <h3 class="text-center">Rate Institute</h3>
                    <div class="row">
                        @if(!empty($instituteDetails))
                        @foreach($instituteDetails as $instituteDetail)
                        <div class="col-lg-12">
                            <div class="company-review has--link">
                                <a href="{{ route('company.details', [$instituteDetail->id, slug($instituteDetail->name)]) }}"
                                    class="item--link"></a>
                                <div class="company-review__top">
                                    <div class="thumb">
                                        <img src="{{ getImage(imagePath()['company']['path'] . '/' . @$instituteDetail->image) }}"
                                            alt="company logo">
                                        @if ($instituteDetail->user_id == auth()->id())
                                        <span class="auth-company">
                                            <i class="la la-user" aria-hidden="true"></i>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="content">
                                        <div class="company-review__name d-flex flex-wrap justify-content-between">
                                            <div class="left-side">
                                                <h6>
                                                    <a
                                                        href="{{ route('company.details', [$instituteDetail->id, slug($instituteDetail->name)]) }}">{{ @$instituteDetail->name }}</a>
                                                </h6>
                                                <p class="cate-name fs--14px"><i class="las la-certificate"></i>
                                                    {{ __($instituteDetail->category->name) }}</p>
                                            </div>
                                            <div class="text-right text--base">
                                                @php echo avgRating($instituteDetail->avg_rating); @endphp
                                                <p class="fs--14px text-muted"> &nbsp;
                                                    {{ $instituteDetail->avg_rating }}
                                                    ({{ @$instituteDetail->reviews_count }}
                                                    @lang('ratings'))
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <span class="fs--14px mt-2 lh-1"><i class="las la-map-marker"></i>
                                        {{ @$instituteDetail->address }}</span>
                                </div>
                                <div class="company-review__ratings mt-3 text--base">
                                    <div class="d-flex justify-content-between">
                                        <span class="fs--14px text-muted d-block">@lang('Registered On') :
                                            {{ showDateTime($instituteDetail->created_at, 'd M Y') }}</span>
                                    </div>
                                </div>
                                <div class="company-review__tags mt-2">
                                     @if(!empty($instituteDetail->tags))
                                        @foreach (@$instituteDetail->tags as $tag)
                                        {{ $tag }}
                                        {{ !$loop->last ? ', ' : null }}
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @endif

                    </div>
                </div>

                <!-- Similar Institute -->
                    @if(!empty($similarInstitutes) && count($similarInstitutes) > 0)
                        <div class="customer-review-wrapper mt-5 mb-5">
                    <h3 class="text-center">Similar Institute's</h3>
                    <div class="row">
                       
                        @foreach($similarInstitutes as $instituteDetail)
                        <div class="col-lg-6">
                            <div class="company-review has--link">
                                <a href="{{ route('company.details', [$instituteDetail->id, slug($instituteDetail->name)]) }}"
                                    class="item--link"></a>
                                <div class="company-review__top">
                                    <div class="thumb">
                                        <img src="{{ getImage(imagePath()['company']['path'] . '/' . @$instituteDetail->image) }}"
                                            alt="company logo">
                                        @if ($instituteDetail->user_id == auth()->id())
                                        <span class="auth-company">
                                            <i class="la la-user" aria-hidden="true"></i>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="content">
                                        <div class="company-review__name d-flex flex-wrap justify-content-between">
                                            <div class="left-side">
                                                <h6>
                                                    <a
                                                        href="{{ route('company.details', [$instituteDetail->id, slug($instituteDetail->name)]) }}">{{ @$instituteDetail->name }}</a>
                                                </h6>
                                                <p class="cate-name fs--14px"><i class="las la-certificate"></i>
                                                    {{ __($instituteDetail->category->name) }}</p>
                                            </div>
                                            <div class="text-right text--base">
                                                @php echo avgRating($instituteDetail->avg_rating); @endphp
                                                <p class="fs--14px text-muted"> &nbsp;
                                                    {{ $instituteDetail->avg_rating }}
                                                    ({{ @$instituteDetail->reviews_count }}
                                                    @lang('ratings'))
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <span class="fs--14px mt-2 lh-1"><i class="las la-map-marker"></i>
                                        {{ @$instituteDetail->address }}</span>
                                </div>
                                <div class="company-review__ratings mt-3 text--base">
                                    <div class="d-flex justify-content-between">
                                        <span class="fs--14px text-muted d-block">@lang('Registered On') :
                                            {{ showDateTime($instituteDetail->created_at, 'd M Y') }}</span>
                                    </div>
                                </div>
                                <div class="company-review__tags mt-2">
                                     @if(!empty($instituteDetail->tags))
                                        @foreach (@$instituteDetail->tags as $tag)
                                        {{ $tag }}
                                        {{ !$loop->last ? ', ' : null }}
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                    @endif
            </div>
        </div>
    </div>
    <!-- review update modal -->
    <div class="modal fade" id="reviewUpdateModal" tabindex="-1" aria-labelledby="reviewUpdateModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reviewUpdateModalLabel">@lang('Update  Review')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('user.update.teacher.review') }}" method="POST">
                        @csrf
                        <div class="row mt-4">
                            <div class="col-sm-12">
                                <div class="card" style="height: 150px;">
                                    <div class="card-header text-center"> Overall - </div>
                                    <div class="card-body"
                                        style="display: flex; justify-content: center; align-items:center;">
                                        <div class='give-rating'>
                                            @for ($i = 5; $i >= 1; $i--)
                                            <span id="existed-rating-{{ $i }}">
                                                <input id='star{{ $i }}' name='rating' type='radio' value='{{ $i }}'>
                                                <label for='star{{ $i }}'><i class="las la-star fa-sm"></i></label>
                                            </span>
                                            @endfor

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 mt-3">
                                <div class="card" style="height: 200px;">
                                    <div class="card-header text-center"
                                        style="height: 100px; display: flex; justify-content: center; align-items: center;">
                                        Friendliness of teaching pedagogy (Positive teaching-learning environment in
                                        class)</div>
                                    <div class="card-body"
                                        style="display: flex; justify-content: center; align-items:center;">
                                        <div class='give-rating'>
                                            @for ($i = 5; $i >= 1; $i--)
                                            <span id="existed-rating1-{{ $i }}">
                                                <input id='star1{{ $i }}' name='friendliness_teaching' type='radio'
                                                    value='{{ $i }}'>
                                                <label for='star1{{ $i }}'><i class="las la-star fa-sm"></i></label>
                                            </span>
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 mt-3">
                                <div class="card" style="height: 200px;">
                                    <div class="card-header text-center"
                                        style="height: 100px; display: flex; justify-content: center; align-items: center;">
                                        Clarity of concept taught (capacity to simplify complex concepts and explain
                                        them)</div>
                                    <div class="card-body"
                                        style="display: flex; justify-content: center; align-items:center;">
                                        <div class='give-rating'>
                                            @for ($i = 5; $i >= 1; $i--)
                                            <span id="existed-rating2-{{ $i }}">
                                                <input id='star2{{ $i }}' name='clarity_of_concept' type='radio'
                                                    value='{{ $i }}'>
                                                <label for='star2{{ $i }}'><i class="las la-star fa-sm"></i></label>
                                            </span>
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 mt-3">
                                <div class="card" style="height: 200px;">
                                    <div class="card-header text-center"
                                        style="height: 100px; display: flex; justify-content: center; align-items: center;">
                                        Communication Skills - command and fluency over teaching language </div>
                                    <div class="card-body"
                                        style="display: flex; justify-content: center; align-items:center;">
                                        <div class='give-rating'>
                                            @for ($i = 5; $i >= 1; $i--)
                                            <span id="existed-rating3-{{ $i }}">
                                                <input id='star3{{ $i }}' name='communication' type='radio'
                                                    value='{{ $i }}'>
                                                <label for='star3{{ $i }}'><i class="las la-star fa-sm"></i></label>
                                            </span>
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 mt-3">
                                <div class="card" style="height: 200px;">
                                    <div class="card-header text-center"
                                        style="height: 100px; display: flex; justify-content: center; align-items: center;">
                                        Student engagement in class/attention to doubt solving </div>
                                    <div class="card-body"
                                        style="display: flex; justify-content: center; align-items:center;">
                                        <div class='give-rating'>
                                            @for ($i = 5; $i >= 1; $i--)
                                            <span id="existed-rating4-{{ $i }}">
                                                <input id='star4{{ $i }}' name='student_engage' type='radio'
                                                    value='{{ $i }}'>
                                                <label for='star4{{ $i }}'><i class="las la-star fa-sm"></i></label>
                                            </span>
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 mt-3">
                                <div class="card" style="height: 200px;">
                                    <div class="card-header text-center"
                                        style="height: 70px; display: flex; justify-content: center; align-items: center;">
                                        Punctuality</div>
                                    <div class="card-body"
                                        style="display: flex; justify-content: center; align-items:center;">
                                        <div class='give-rating'>
                                            @for ($i = 5; $i >= 1; $i--)
                                            <span id="existed-rating5-{{ $i }}">
                                                <input id='star5{{ $i }}' name='punctuality' type='radio'
                                                    value='{{ $i }}'>
                                                <label for='star5{{ $i }}'><i class="las la-star fa-sm"></i></label>
                                            </span>
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 mt-3">
                                <div class="card" style="height: 200px;">
                                    <div class="card-header text-center"> Syllabus completed as per communicated
                                        commitment at the start of the course - </div>
                                    <div class="card-body"
                                        style="display: flex; justify-content: center; align-items:center;">
                                        <div class='give-rating'>
                                            @for ($i = 5; $i >= 1; $i--)
                                            <span id="existed-rating6-{{ $i }}">
                                                <input id='star6{{ $i }}' name='syllabus_completed' type='radio'
                                                    value='{{ $i }}'>
                                                <label for='star6{{ $i }}'><i class="las la-star fa-sm"></i></label>
                                            </span>
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-3">
                                <div class="card" style="height: 200px;">
                                    <div class="card-header text-center"> Content validity : Previous year questions
                                        and/or solvable through class teaching (* except questions related to current
                                        affairs - previous year's questions may not be very valid for the current year )
                                    </div>
                                    <div class="card-body"
                                        style="display: flex; justify-content: center; align-items:center;">
                                        <div class='give-rating'>
                                            @for ($i = 5; $i >= 1; $i--)
                                            <span id="existed-rating7-{{ $i }}">
                                                <input id='star7{{ $i }}' name='content_validity' type='radio'
                                                    value='{{ $i }}'>
                                                <label for='star7{{ $i }}'><i class="las la-star fa-sm"></i></label>
                                            </span>
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" class="edit-id" value="" name="id">
                        <textarea name="review" class="form--control edit-review12 mt-3"
                            placeholder="@lang('Write your review')"></textarea>
                        <div class="text-end">
                            <button type="submit" class="btn btn--base">@lang('Update')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

       <!-- login modal -->
       <div class="modal fade"  id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content" style="background:#17173a; border-radius: 30px;">
                    <div class="modal-header">
                        <h5 class="modal-title" id="loginModalModalLabel" style="color:#fff;">@lang('Login')</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    <form class="account-form" method="POST" action="{{ route('user.login') }}"
                    onsubmit="return submitUserForm();">
                    @csrf
                    <div class="form-group">
                        <label>@lang('Username or Email')</label>
                        <input type="text" name="username" autocomplete="off" class="form--control" placeholder="@lang('Username or Email')" required>
                    </div>

                    <div class="form-group">
                        <label>@lang('Password')</label>
                        <div class="input-group">
                            <input type="password" name="password" autocomplete="off" class="form--control" placeholder="@lang('Password')" required>
                            <button type="button" class="input-group-text border-0 bg--base text-white toggle-password">
                                <i class="la la-eye"></i>
                            </button>
                        </div>
                    </div>

                  
                    @include($activeTemplate . 'partials.custom_captcha')

                    @php
                        $captcha = loadReCaptcha();
                    @endphp

                    @if($captcha)
                        <div class="form-group col-12">
                            @php echo $captcha @endphp
                        </div>
                    @endif

                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">
                                @lang('Remember Me')
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" id="recaptcha" class="btn btn--base w-100">@lang('Login')</button>
                    </div>
                    <div class="form-group">
                        <a class=" btn-link text-decoration-none text--base" href="{{ route('user.password.request') }}">
                            @lang('Forgot Password?')
                        </a>
                    </div>
                </form>
                <div class="text-center">
                    <p style="color:#fff;">or login using -</p>
                    <a href="{{ url('authorized/google') }}">
                        <img src="https://cdn-icons-png.flaticon.com/512/2991/2991148.png" style="width: 30px;" class="m-2">
                    </a>
                    <a href="{{ url('redirect') }}"  id="btn-fblogin">
                    <img src="https://cdn-icons-png.flaticon.com/512/3536/3536394.png" style=" width: 30px;" class="m-2">
                    </a>
                    <a  href="{{ url('auth/linkedin') }}">
                    <img src="https://freeiconshop.com/wp-content/uploads/edd/linkedin-flat.png" style=" width: 30px;" class="m-2"> 
                    </a>
                </div>    
            </div>
            <div class="bottom w-100 text-center mb-3">
                <p class="mb-0 sm-text text-center" style="color:#fff;">
                    Don't have an account? <a href="{{ route('user.register') }}">Create Now</a> 
                </p>
            </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End login ModaL -->

    <!-- review delete modal -->
    <div class="modal fade" id="reviewDeleteModal" tabindex="-1" aria-labelledby="reviewDeleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reviewDeleteModalLabel">@lang('Confirmation Alert')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>@lang('Are you sure to delete this review?')</p>
                </div>
                <div class="modal-footer">
                    <form action="{{ route('user.delete.teacher.review') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="" class="delete-id">
                        <button type="button" class="btn btn-sm btn--dark" data-bs-dismiss="modal">@lang('No')</button>
                        <button type="submit" class="btn btn-sm btn--base">@lang('Yes')</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('script')
<script>
        "use strict";

        function submitUserForm() {
            var response = grecaptcha.getResponse();
            if (response.length == 0) {
                document.getElementById('g-recaptcha-error').innerHTML =
                    '<span class="text-danger">@lang("Captcha field is required.")</span>';
                return false;
            }
            return true;
        }

        //ShowHide-password//
        $(".toggle-password").on('click', function() {
            $(this).find('i').toggleClass("las la-eye-slash");
            var input = $(this).siblings('input');
            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });
</script>

<script>
    "use strict";
    $(document).ready(function () {

        //update review
        $('.edit-review').on('click', function () {

            var result = $(this).data();

            console.log('result', result);
            $('.edit-id').val(result.id);
            $('.edit-review12').val(result.review);

            $('#reviewUpdateModal').find('input[name=rating]').parent('span').removeClass('checked');
            $('#reviewUpdateModal').find('input[name=friendliness_teaching]').parent('span').removeClass('checked');
            $('#reviewUpdateModal').find('input[name=clarity_of_concept]').parent('span').removeClass('checked');
            $('#reviewUpdateModal').find('input[name=communication]').parent('span').removeClass('checked');
            $('#reviewUpdateModal').find('input[name=student_engage]').parent('span').removeClass('checked');
            $('#reviewUpdateModal').find('input[name=punctuality]').parent('span').removeClass('checked');
            $('#reviewUpdateModal').find('input[name=content_validity]').parent('span').removeClass('checked');
            $('#reviewUpdateModal').find('input[name=syllabus_completed]').parent('span').removeClass('checked');
            var existRating = result.rating;
            var teaching_faculty = result.friendliness_teaching;
            var infra_quality = result.clarity_of_concept;
            var technology_friendly = result.communication;
            var counseling_quality = result.student_engage;
            var operational_manage = result.punctuality;
            var attitude_management = result.content_validity;
            var quality_classroom = result.syllabus_completed;

            if (existRating == 5) {
                $('#existed-rating-5').addClass('checked');
            } else if (existRating == 4) {
                $('#existed-rating-4').addClass('checked');
            } else if (existRating == 3) {
                $('#existed-rating-3').addClass('checked');
            } else if (existRating == 2) {
                $('#existed-rating-2').addClass('checked');
            } else {
                $('#existed-rating-1').addClass('checked');
            }

            if (teaching_faculty == 5) {
                $('#existed-rating1-5').addClass('checked');
            } else if (teaching_faculty == 4) {
                $('#existed-rating1-4').addClass('checked');
            } else if (teaching_faculty == 3) {
                $('#existed-rating1-3').addClass('checked');
            } else if (teaching_faculty == 2) {
                $('#existed-rating1-2').addClass('checked');
            } else {
                $('#existed-rating1-1').addClass('checked');
            }

            if (infra_quality == 5) {
                $('#existed-rating2-5').addClass('checked');
            } else if (infra_quality == 4) {
                $('#existed-rating2-4').addClass('checked');
            } else if (infra_quality == 3) {
                $('#existed-rating2-3').addClass('checked');
            } else if (infra_quality == 2) {
                $('#existed-rating2-2').addClass('checked');
            } else {
                $('#existed-rating2-1').addClass('checked');
            }

            if (technology_friendly == 5) {
                $('#existed-rating3-5').addClass('checked');
            } else if (technology_friendly == 4) {
                $('#existed-rating3-4').addClass('checked');
            } else if (technology_friendly == 3) {
                $('#existed-rating3-3').addClass('checked');
            } else if (technology_friendly == 2) {
                $('#existed-rating3-2').addClass('checked');
            } else {
                $('#existed-rating3-1').addClass('checked');
            }

            if (counseling_quality == 5) {
                $('#existed-rating4-5').addClass('checked');
            } else if (counseling_quality == 4) {
                $('#existed-rating4-4').addClass('checked');
            } else if (counseling_quality == 3) {
                $('#existed-rating4-3').addClass('checked');
            } else if (counseling_quality == 2) {
                $('#existed-rating4-2').addClass('checked');
            } else {
                $('#existed-rating4-1').addClass('checked');
            }

            if (operational_manage == 5) {
                $('#existed-rating5-5').addClass('checked');
            } else if (operational_manage == 4) {
                $('#existed-rating5-4').addClass('checked');
            } else if (operational_manage == 3) {
                $('#existed-rating5-3').addClass('checked');
            } else if (operational_manage == 2) {
                $('#existed-rating5-2').addClass('checked');
            } else {
                $('#existed-rating5-1').addClass('checked');
            }

            if (attitude_management == 5) {
                $('#existed-rating7-5').addClass('checked');
            } else if (attitude_management == 4) {
                $('#existed-rating7-4').addClass('checked');
            } else if (attitude_management == 3) {
                $('#existed-rating7-3').addClass('checked');
            } else if (attitude_management == 2) {
                $('#existed-rating7-2').addClass('checked');
            } else {
                $('#existed-rating7-1').addClass('checked');
            }

            if (quality_classroom == 5) {
                $('#existed-rating6-5').addClass('checked');
            } else if (quality_classroom == 4) {
                $('#existed-rating6-4').addClass('checked');
            } else if (quality_classroom == 3) {
                $('#existed-rating6-3').addClass('checked');
            } else if (quality_classroom == 2) {
                $('#existed-rating6-2').addClass('checked');
            } else {
                $('#existed-rating6-1').addClass('checked');
            }
        });

        //delete review
        $('.delete-review').on('click', function () {
            $('.delete-id').val($(this).data('id'));
        });

        //prime review Radio-box
        $(".give-rating input:radio").attr("checked", false);

        $(".give-rating input").click(function (e) {
            $(this).parent().siblings().removeClass("checked");
            $(this)
                .parent()
                .addClass("checked");
        });

        //update review Radio-box

        $(".give-rating-update input:radio").attr("checked", false);

        $(".give-rating-update input").click(function (e) {
            $(this).parent().siblings().removeClass("checked");
            $(this)
                .parent()
                .addClass("checked");
        });
    });

</script>
@endpush
