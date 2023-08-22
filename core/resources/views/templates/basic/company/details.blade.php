@extends($activeTemplate.'layouts.frontend')
@php
$content = getContent('breadcrumb.content', true);
@endphp
@section('content')
    <section class="section--bg pb-100">
        <div class="company-details-bg bg_img d-lg-block d-none" style="background-image: url('{{ getImage('assets/images/frontend/breadcrumb/' . @$content->data_values->image, '1920x840') }}');">
        </div>
        <div class="company-details-header">
            <div class="container">
                <div class="row justify-content-end">
                    <div class="col-lg-8 ps-xxl-5">
                        <div class="row gy-4">
                            <div class="col-md-8 text-md-start text-center">
                                <div class="company-profile">
                                    <h3 class="company-profile__name">{{ $company->name }}</h3>
                                    <span><i class="las la-map-marker-alt"></i>{{ $company->address }}</span> <br>
                                    <span><i class="las la-external-link-alt"></i> <a target="_blank" href="{{ $company->url }}">{{ $company->url }}</a> </span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="company-website section--bg2 text-center has--link">
                                    @php $alreadyClaim = App\Models\Claim::latest()->where('user_id', auth()->id())->where('t_i_id', $company->id)->where('status', 1)->first(); @endphp 
                                    @if(empty($alreadyClaim))
                                        <a href="{{ route('user.claimInstituteProfile', ['id' => $company->id]) }}" class="item--link"></a>
                                        <h6 class="fs--16px text-white"><i
                                                class="las la-external-link-alt"></i></h6>
                                        <span class="fs--12px text-white">@lang('Claim this Institute')</span>
                                    @else 
                                        <h6 class="fs--16px text-white"><i
                                                class="las la-external-link-alt"></i></h6>
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
                                            {{ @$company->reviews_count }} @lang('Reviews')</span>
                                    </div>
                                </div>

                                @for ($i = 5; $i >= 1; $i--)
                                    @php
                                        $reviewCount = $company->reviews->where('rating', $i)->count();
                                        $percentage = 0;
                                        if ($reviewCount) {
                                            $percentage = ($reviewCount / $company->reviews_count) * 100;
                                        }
                                    @endphp

                                    <div class="single-review">
                                        <p class="star">{{ $i }} <i class="las la-star text--base"></i>
                                        </p>
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar"
                                                style="width: {{ $percentage }}%" aria-valuenow="{{ $percentage }}"
                                                aria-valuemin="0" aria-valuemax="100"></div>
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
                                $CompanyReviewCount = $company->reviews->count();
                                if($CompanyReviewCount > 0) {
                                    $teaching_faculty =   $company->reviews->sum('teaching_faculty') / $CompanyReviewCount;
                                    $infra_quality =  $company->reviews->sum('infra_quality') / $CompanyReviewCount;
                                    $technology_friendly =  $company->reviews->sum('technology_friendly') / $CompanyReviewCount;
                                    $counseling_quality =  $company->reviews->sum('counseling_quality') / $CompanyReviewCount;
                                    $operational_manage =  $company->reviews->sum('operational_manage') / $CompanyReviewCount;
                                    $attitude_management =  $company->reviews->sum('attitude_management') / $CompanyReviewCount;
                                    $quality_classroom =  $company->reviews->sum('quality_classroom') / $CompanyReviewCount;
                                    $tests =  $company->reviews->sum('tests') / $CompanyReviewCount;
                                    $quality_study =  $company->reviews->sum('quality_study') / $CompanyReviewCount;
                                    $current_affair =  $company->reviews->sum('current_affair') / $CompanyReviewCount;
                                    $interview_guidance =  $company->reviews->sum('interview_guidance') / $CompanyReviewCount;     
                                }else  {
                                        $teaching_faculty =  0;
                                        $infra_quality =  0;
                                        $technology_friendly =  0;
                                        $counseling_quality =  0;
                                        $operational_manage = 0;
                                        $attitude_management =  0;
                                        $quality_classroom =  0;
                                        $tests =  0;
                                        $quality_study =  0;
                                        $current_affair =  0;
                                        $interview_guidance = 0;
                                }
                                @endphp

                                <div class="ag-format-container">
                                    <ul class="mt-3">
                                        <li title="Having Good Teacher Facility"> <b>Having Good Teacher Facility</b> <br>
                                        <p>  {{ showAmount($teaching_faculty) }}  (
                                                @php
                                                    echo avgRating($teaching_faculty);
                                                @endphp) 
                                        </p>
                                        </li> 
                                        <hr>
                                         <li title="Campus Infrastructure Quality (adequate space, facilities, quality of infrastructural arrangements"> <b>Campus Infrastructure Quality</b> <br>
                                        <p>  {{ showAmount($infra_quality) }}  (
                                                @php
                                                    echo avgRating($infra_quality);
                                                @endphp) 
                                        </p>
                                        </li> 
                                        <hr>
                                          <li title="Technology Friendliness (use of technology in teaching - use of digital tools/videos/online interface/ease of online interaction)"> <b> Technology Friendliness </b> <br>
                                        <p>  {{ showAmount($technology_friendly) }}  (
                                                @php
                                                    echo avgRating($technology_friendly);
                                                @endphp) 
                                        </p>
                                        </li> 
                                        <hr>
                                          <li title="Counselling Quality/detailed/relevant explanation at the time of admission"> <b> Counselling Quality  </b> <br>
                                        <p>  {{ showAmount($counseling_quality) }}  (
                                                @php
                                                    echo avgRating($counseling_quality);
                                                @endphp) 
                                        </p>
                                        </li> 
                                        <hr>
                                         <li title="Operational Management efficiency/ day to day management efficiency/ scheduling of classes"> <b> Operational Management </b> <br>
                                        <p>  {{ showAmount($operational_manage) }}  (
                                                @php
                                                    echo avgRating($operational_manage);
                                                @endphp) 
                                        </p>
                                        </li> 
                                        <hr>
                                         <li title="Positive Attitude of management/Friendliness in dealing with operational issues/queries raised by students"> <b> Positive Attitude </b> <br>
                                        <p>  {{ showAmount($attitude_management) }}  (
                                                @php
                                                    echo avgRating($attitude_management);
                                                @endphp) 
                                        </p>
                                        </li> 
                                        <hr>
                                          <li title="Quality of classroom teaching "> <b>  Quality of classroom teaching </b> <br>
                                        <p>  {{ showAmount($quality_classroom) }}  (
                                                @php
                                                    echo avgRating($quality_classroom);
                                                @endphp) 
                                        </p>
                                        </li> 
                                        <hr>
                                        <li title="Tests and Checking "> <b>  Tests and Checking </b> <br>
                                        <p>  {{ showAmount($tests) }}  (
                                                @php
                                                    echo avgRating($tests);
                                                @endphp) 
                                        </p>
                                        </li> 
                                        <hr>
                                        <li title="Quality of study material provided"> <b>  Quality of study material provided </b> <br>
                                        <p>  {{ showAmount($quality_study) }}  (
                                                @php
                                                    echo avgRating($quality_study);
                                                @endphp) 
                                        </p>
                                        </li> 
                                        <hr>
                                         <li title=" Current Affairs"> <b>  Current Affairs </b> <br>
                                        <p>  {{ showAmount($current_affair) }}  (
                                                @php
                                                    echo avgRating($current_affair);
                                                @endphp) 
                                        </p>
                                        </li> 
                                        <hr>
                                         <li title="Interview guidance program"> <b>  Interview guidance program</b> <br>
                                        <p>  {{ showAmount($interview_guidance) }}  (
                                                @php
                                                    echo avgRating($interview_guidance);
                                                @endphp) 
                                        </p>
                                        </li> 
                                        <hr>
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
                                        @foreach (@$company->tags as $tag)
                                            {{ $tag }}
                                            @if (!$loop->last)
                                                ,
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                                <div class="single-company-info">
                                    <h5 class="single-company-info__title">@lang('Contact Info')</h5>
                                    <ul class="single-company-info__list">
                                        <li>
                                            <div class="icon"><i class="las la-link"></i></div>
                                            <div class="content"><a
                                                    href="{{ @$company->url }}">{{ @$company->url }}</a></div>
                                        </li>
                                        <li>
                                            <div class="icon"><i class="las la-map-marker-alt"></i></div>
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
                            <form action="{{ route('user.review', $company->id) }}" method="post">
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
                                                <div class="card-body" style="display: flex; justify-content: center; align-items:center;">
                                                    <div class='give-rating'>
                                                        @for ($i = 5; $i >= 1; $i--)
                                                            <span>
                                                                <input id='str{{ $i }}' name='rating' type='radio'
                                                                    value='{{ $i }}'>
                                                                <label for='str{{ $i }}'><i class="las la-star fa-sm"></i></label>
                                                            </span>
                                                        @endfor
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 mt-3">
                                            <div class="card" style="height: 200px;">
                                                <div class="card-header text-center" style="height: 100px; display: flex; justify-content: center; align-items: center;"> Having good Teaching faculty</div>
                                                <div class="card-body" style="display: flex; justify-content: center; align-items:center;">
                                                    <div class='give-rating'>
                                                        @for ($i = 5; $i >= 1; $i--)
                                                            <span>
                                                                <input id='str1{{ $i }}' name='teaching_faculty' type='radio'
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
                                                <div class="card-header text-center"> Campus Infrastructure Quality (adequate space, facilities, quality of infrastructural arrangements)</div>
                                                <div class="card-body" style="display: flex; justify-content: center; align-items:center;">
                                                    <div class='give-rating'>
                                                        @for ($i = 5; $i >= 1; $i--)
                                                            <span>
                                                                <input id='str2{{ $i }}' name='infra_quality' type='radio'
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
                                                <div class="card-header text-center"> Technology Friendliness (use of technology in teaching - use of digital tools/video/online interface/ease of online interaction)</div>
                                                <div class="card-body" style="display: flex; justify-content: center; align-items:center;">
                                                    <div class='give-rating'>
                                                        @for ($i = 5; $i >= 1; $i--)
                                                            <span>
                                                                <input id='str3{{ $i }}' name='technology_friendly' type='radio'
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
                                                <div class="card-header text-center" style="height: 100px; display: flex; justify-content: center; align-items: center;"> Counseling Quality/detailed/relevant explanation at the time of admission</div>
                                                <div class="card-body" style="display: flex; justify-content: center; align-items:center;">
                                                    <div class='give-rating'>
                                                        @for ($i = 5; $i >= 1; $i--)
                                                            <span>
                                                                <input id='str4{{ $i }}' name='counseling_quality' type='radio'
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
                                                <div class="card-header text-center" style="height: 100px; display: flex; justify-content: center; align-items: center;"> Operational management Efficiency/ day to day management</div>
                                                <div class="card-body" style="display: flex; justify-content: center; align-items:center;">
                                                    <div class='give-rating'>
                                                        @for ($i = 5; $i >= 1; $i--)
                                                            <span>
                                                                <input id='str5{{ $i }}' name='operational_manage' type='radio'
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
                                                <div class="card-header text-center"> Positive attitude of management/friendliness in dealing with operational issues/queries raised by students</div>
                                                <div class="card-body" style="display: flex; justify-content: center; align-items:center;">
                                                    <div class='give-rating'>
                                                        @for ($i = 5; $i >= 1; $i--)
                                                            <span>
                                                                <input id='str6{{ $i }}' name='attitude_management' type='radio'
                                                                    value='{{ $i }}'>
                                                                <label for='str6{{ $i }}'><i class="las la-star fa-sm"></i></label>
                                                            </span>
                                                        @endfor
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 mt-3">
                                            <div class="card" style="height: 320px;">
                                                <div class="card-header text-center"> Deliverables - </div>
                                                <div class="card-body" style="align-items: center;">
                                                    <div class='give-rating' style="display: flex; justify-content: space-between;">
                                                       
                                                                <p>   1. Quality of classroom</p>
                                                                <div>
                                                                    @for ($i = 5; $i >= 1; $i--)
                                                                        <span>
                                                                            <input id='str7{{ $i }}' name='quality_classroom' type='radio'
                                                                                value='{{ $i }}'>
                                                                            <label for='str7{{ $i }}'><i class="las la-star fa-sm"></i></label>
                                                                        </span>
                                                                    @endfor
                                                                </div>
                                                    </div>              
                                                    <div class='give-rating' style="display: flex; justify-content: space-between;">
                                                                <p> 2. tests and checking </p>
                                                                <div>
                                                                    @for ($i = 5; $i >= 1; $i--)
                                                                        <span>
                                                                            <input id='str8{{ $i }}' name='tests' type='radio'
                                                                                value='{{ $i }}'>
                                                                            <label for='str8{{ $i }}'><i class="las la-star fa-sm"></i></label>
                                                                        </span>
                                                                    @endfor
                                                                </div>
                                                    </div>
                                                    <div class='give-rating' style="display: flex; justify-content: space-between;">
                                                                <p> 3. Quality of study  </p>
                                                                <div>
                                                                    @for ($i = 5; $i >= 1; $i--)
                                                                        <span>
                                                                            <input id='str9{{ $i }}' name='quality_study' type='radio'
                                                                                value='{{ $i }}'>
                                                                            <label for='str9{{ $i }}'><i class="las la-star fa-sm"></i></label>
                                                                        </span>
                                                                    @endfor
                                                                </div>
                                                    </div>          
                                                    <div class='give-rating' style="display: flex; justify-content: space-between;">
                                                                <p> 4. Current affairs  </p>
                                                                <div>
                                                                    @for ($i = 5; $i >= 1; $i--)
                                                                        <span>
                                                                            <input id='str11{{ $i }}' name='current_affair' type='radio'
                                                                                value='{{ $i }}'>
                                                                            <label for='str11{{ $i }}'><i class="las la-star fa-sm"></i></label>
                                                                        </span>
                                                                    @endfor
                                                                </div>
                                                    </div>          
                                                    <div class='give-rating' style="display: flex; justify-content: space-between;">
                                                                <p> 5. interview guidance program </p>
                                                                <div>
                                                                    @for ($i = 5; $i >= 1; $i--)
                                                                        <span>
                                                                            <input id='str12{{ $i }}' name='interview_guidance' type='radio'
                                                                                value='{{ $i }}'>
                                                                            <label for='str12{{ $i }}'><i class="las la-star fa-sm"></i></label>
                                                                        </span>
                                                                    @endfor
                                                                </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                <div class="mt-4">
                                    <textarea name="review" class="form--control" placeholder="@lang('Write review')" required>{{ old('review') }}</textarea>
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
                                                <div class="card-body" style="display: flex; justify-content: center; align-items:center;">
                                                    <div class='give-rating'>
                                                        @for ($i = 5; $i >= 1; $i--)
                                                            <span>
                                                                <input id='str{{ $i }}' name='rating' type='radio' data-bs-toggle="modal" data-bs-target="#loginModal"
                                                                    value='{{ $i }}'>
                                                                <label for='str{{ $i }}'><i class="las la-star fa-sm"></i></label>
                                                            </span>
                                                        @endfor
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 mt-3">
                                            <div class="card" style="height: 200px;">
                                                <div class="card-header text-center" style="height: 100px; display: flex; justify-content: center; align-items: center;"> Having good Teaching faculty</div>
                                                <div class="card-body" style="display: flex; justify-content: center; align-items:center;">
                                                    <div class='give-rating'>
                                                        @for ($i = 5; $i >= 1; $i--)
                                                            <span>
                                                                <input id='str1{{ $i }}' name='teaching_faculty' type='radio' data-bs-toggle="modal" data-bs-target="#loginModal" value='{{ $i }}'>
                                                                <label for='str1{{ $i }}'><i class="las la-star fa-sm"></i></label>
                                                            </span>
                                                        @endfor
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 mt-3">
                                            <div class="card" style="height: 200px;">
                                                <div class="card-header text-center"> Campus Infrastructure Quality (adequate space, facilities, quality of infrastructural arrangements)</div>
                                                <div class="card-body" style="display: flex; justify-content: center; align-items:center;">
                                                    <div class='give-rating'>
                                                        @for ($i = 5; $i >= 1; $i--)
                                                            <span>
                                                                <input id='str2{{ $i }}' name='infra_quality' type='radio' data-bs-toggle="modal" data-bs-target="#loginModal" value='{{ $i }}'>
                                                                <label for='str2{{ $i }}'><i class="las la-star fa-sm"></i></label>
                                                            </span>
                                                        @endfor
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 mt-3">
                                            <div class="card" style="height: 200px;">
                                                <div class="card-header text-center"> Technology Friendliness (use of technology in teaching - use of digital tools/video/online interface/ease of online interaction)</div>
                                                <div class="card-body" style="display: flex; justify-content: center; align-items:center;">
                                                    <div class='give-rating'>
                                                        @for ($i = 5; $i >= 1; $i--)
                                                            <span>
                                                                <input id='str3{{ $i }}' name='technology_friendly' type='radio' data-bs-toggle="modal" data-bs-target="#loginModal"
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
                                                <div class="card-header text-center" style="height: 100px; display: flex; justify-content: center; align-items: center;"> Counseling Quality/detailed/relevant explanation at the time of admission</div>
                                                <div class="card-body" style="display: flex; justify-content: center; align-items:center;">
                                                    <div class='give-rating'>
                                                        @for ($i = 5; $i >= 1; $i--)
                                                            <span>
                                                                <input id='str4{{ $i }}' name='counseling_quality' type='radio' data-bs-toggle="modal" data-bs-target="#loginModal"
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
                                                <div class="card-header text-center" style="height: 100px; display: flex; justify-content: center; align-items: center;"> Operational management Efficiency/ day to day management</div>
                                                <div class="card-body" style="display: flex; justify-content: center; align-items:center;">
                                                    <div class='give-rating'>
                                                        @for ($i = 5; $i >= 1; $i--)
                                                            <span>
                                                                <input id='str5{{ $i }}' name='operational_manage' type='radio' data-bs-toggle="modal" data-bs-target="#loginModal"
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
                                                <div class="card-header text-center"> Positive attitude of management/friendliness in dealing with operational issues/queries raised by students</div>
                                                <div class="card-body" style="display: flex; justify-content: center; align-items:center;">
                                                    <div class='give-rating'>
                                                        @for ($i = 5; $i >= 1; $i--)
                                                            <span>
                                                                <input id='str6{{ $i }}' name='attitude_management' type='radio' data-bs-toggle="modal" data-bs-target="#loginModal"
                                                                    value='{{ $i }}'>
                                                                <label for='str6{{ $i }}'><i class="las la-star fa-sm"></i></label>
                                                            </span>
                                                        @endfor
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 mt-3">
                                            <div class="card" style="height: 320px;">
                                                <div class="card-header text-center"> Deliverables - </div>
                                                <div class="card-body" style="align-items: center;">
                                                    <div class='give-rating' style="display: flex; justify-content: space-between;">
                                                       
                                                                <p>   1. Quality of classroom</p>
                                                                <div>
                                                                    @for ($i = 5; $i >= 1; $i--)
                                                                        <span>
                                                                            <input id='str7{{ $i }}' name='quality_classroom' type='radio' data-bs-toggle="modal" data-bs-target="#loginModal"
                                                                                value='{{ $i }}'>
                                                                            <label for='str7{{ $i }}'><i class="las la-star fa-sm"></i></label>
                                                                        </span>
                                                                    @endfor
                                                                </div>
                                                    </div>              
                                                    <div class='give-rating' style="display: flex; justify-content: space-between;">
                                                                <p> 2. tests and checking </p>
                                                                <div>
                                                                    @for ($i = 5; $i >= 1; $i--)
                                                                        <span>
                                                                            <input id='str8{{ $i }}' name='tests' type='radio' data-bs-toggle="modal" data-bs-target="#loginModal"
                                                                                value='{{ $i }}'>
                                                                            <label for='str8{{ $i }}'><i class="las la-star fa-sm"></i></label>
                                                                        </span>
                                                                    @endfor
                                                                </div>
                                                    </div>
                                                    <div class='give-rating' style="display: flex; justify-content: space-between;">
                                                                <p> 3. Quality of study  </p>
                                                                <div>
                                                                    @for ($i = 5; $i >= 1; $i--)
                                                                        <span>
                                                                            <input id='str9{{ $i }}' name='quality_study' type='radio' data-bs-toggle="modal" data-bs-target="#loginModal"
                                                                                value='{{ $i }}'>
                                                                            <label for='str9{{ $i }}'><i class="las la-star fa-sm"></i></label>
                                                                        </span>
                                                                    @endfor
                                                                </div>
                                                    </div>          
                                                    <div class='give-rating' style="display: flex; justify-content: space-between;">
                                                                <p> 4. Current affairs  </p>
                                                                <div>
                                                                    @for ($i = 5; $i >= 1; $i--)
                                                                        <span>
                                                                            <input id='str11{{ $i }}' name='current_affair' type='radio' data-bs-toggle="modal" data-bs-target="#loginModal"
                                                                                value='{{ $i }}'>
                                                                            <label for='str11{{ $i }}'><i class="las la-star fa-sm"></i></label>
                                                                        </span>
                                                                    @endfor
                                                                </div>
                                                    </div>          
                                                    <div class='give-rating' style="display: flex; justify-content: space-between;">
                                                                <p> 5. interview guidance program </p>
                                                                <div>
                                                                    @for ($i = 5; $i >= 1; $i--)
                                                                        <span>
                                                                            <input id='str12{{ $i }}' name='interview_guidance' type='radio' data-bs-toggle="modal" data-bs-target="#loginModal"
                                                                                value='{{ $i }}'>
                                                                            <label for='str12{{ $i }}'><i class="las la-star fa-sm"></i></label>
                                                                        </span>
                                                                    @endfor
                                                                </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div> 
                        <!-- <div class="give-rating-area mb-5">
                            <p class="text-center">@lang('You need to')
                                <a href="{{ route('user.login') }}"  class="text--base">@lang('Login')</a> @lang(' first to submit your review.')
                            </p>
                        </div> --> 

                    @endauth
                    <div class="customer-review-wrapper">
                        @include($activeTemplate . 'partials.company_review')
                    </div>

                    <div class="customer-review-wrapper mt-5 mb-5">
                                <h3 class="text-center">Rate Institute Teacher's</h3>
                                <div class="row">
                    @forelse ($instituteTeacher as $k => $company1)
                            <div class="col-lg-6 mt-3">
                                <div class="company-review has--link">
                                    <a href="{{ route('teacher.details', [$company1->id, slug($company1->name)]) }}" class="item--link"></a>
                                    <div class="company-review__top">
                                        <div class="thumb">
                                            <img src="{{ getImage(imagePath()['company']['path'] . '/' . @$company1->image) }}" alt="company logo">
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
                                                        <a href="{{ route('teacher.details', [$company1->id, slug($company1->name)]) }}">{{ @$company1->name }}</a>
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
                                        <span class="fs--14px mt-2 lh-1"><i class="las la-map-marker"></i> {{ @$company1->address }}</span>
                                    </div>
                                    <div class="company-review__ratings mt-3 text--base">
                                        <div class="d-flex justify-content-between">
                                            <span class="fs--14px text-muted d-block">@lang('Registered On') : {{ showDateTime($company1->created_at, 'd M Y') }}</span>
                                        </div>
                                    </div>
                                    <div class="company-review__tags mt-2">

                                        @foreach (@$company1->tags as $tag)
                                            {{ $tag }}
                                            {{ !$loop->last ? ', ' : null }}
                                        @endforeach
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
        <!-- review update modal -->
        <div class="modal fade" id="reviewUpdateModal" tabindex="-1" aria-labelledby="reviewUpdateModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="reviewUpdateModalLabel">@lang('Update Review')</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('user.update.review') }}" method="POST">
                            @csrf
                            <div class="row mt-4">
                                        <div class="col-sm-12">
                                            <div class="card" style="height: 150px;">
                                                <div class="card-header text-center"> Overall </div>
                                                <div class="card-body" style="display: flex; justify-content: center; align-items:center;">
                                                    <div class='give-rating'>
                                                        @for ($i = 5; $i >= 1; $i--)
                                                            <span id="existed-rating-{{ $i }}">
                                                                <input id='star{{ $i }}' name='rating' type='radio'
                                                                    value='{{ $i }}'>
                                                                <label for='star{{ $i }}'><i class="las la-star fa-sm"></i></label>
                                                            </span>
                                                        @endfor
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 mt-3">
                                            <div class="card" style="height: 200px;">
                                                <div class="card-header text-center" style="height: 100px; display: flex; justify-content: center; align-items: center;"> Having good Teaching faculty</div>
                                                <div class="card-body" style="display: flex; justify-content: center; align-items:center;">
                                                    <div class='give-rating'>
                                                        @for ($i = 5; $i >= 1; $i--)
                                                            <span id="existed-rating1-{{ $i }}">
                                                                <input id='star1{{ $i }}' name='teaching_faculty' type='radio'
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
                                                <div class="card-header text-center"> Campus Infrastructure Quality (adequate space, facilities, quality of infrastructural arrangements)</div>
                                                <div class="card-body" style="display: flex; justify-content: center; align-items:center;">
                                                    <div class='give-rating'>
                                                        @for ($i = 5; $i >= 1; $i--)
                                                            <span id="existed-rating2-{{ $i }}">
                                                                <input id='star2{{ $i }}' name='infra_quality' type='radio'
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
                                                <div class="card-header text-center"> Technology Friendliness (use of technology in teaching - use of digital tools/video/online interface/ease of online interaction)</div>
                                                <div class="card-body" style="display: flex; justify-content: center; align-items:center;">
                                                    <div class='give-rating'>
                                                        @for ($i = 5; $i >= 1; $i--)
                                                            <span id="existed-rating3-{{ $i }}"> 
                                                                <input id='star3{{ $i }}' name='technology_friendly' type='radio'
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
                                                <div class="card-header text-center" style="height: 100px; display: flex; justify-content: center; align-items: center;"> Counseling Quality/detailed/relevant explanation at the time of admission</div>
                                                <div class="card-body" style="display: flex; justify-content: center; align-items:center;">
                                                    <div class='give-rating'>
                                                        @for ($i = 5; $i >= 1; $i--)
                                                            <span id="existed-rating4-{{ $i }}">
                                                                <input id='star4{{ $i }}' name='counseling_quality' type='radio'
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
                                                <div class="card-header text-center" style="height: 100px; display: flex; justify-content: center; align-items: center;"> Operational management Efficiency/ day to day management</div>
                                                <div class="card-body" style="display: flex; justify-content: center; align-items:center;">
                                                    <div class='give-rating'>
                                                        @for ($i = 5; $i >= 1; $i--)
                                                            <span id="existed-rating5-{{ $i }}">
                                                                <input id='star5{{ $i }}' name='operational_manage' type='radio'
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
                                                <div class="card-header text-center"> Positive attitude of management/friendliness in dealing with operational issues/queries raised by students</div>
                                                <div class="card-body" style="display: flex; justify-content: center; align-items:center;">
                                                    <div class='give-rating'>
                                                        @for ($i = 5; $i >= 1; $i--)
                                                            <span id="existed-rating6-{{ $i }}">
                                                                <input id='star6{{ $i }}' name='attitude_management' type='radio'
                                                                    value='{{ $i }}'>
                                                                <label for='star6{{ $i }}'><i class="las la-star fa-sm"></i></label>
                                                            </span>
                                                        @endfor
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 mt-3">
                                            <div class="card" style="height: 320px;">
                                                <div class="card-header text-center"> Deliverables </div>
                                                <div class="card-body" style="align-items: center;">
                                                    <div class='give-rating' style="display: flex; justify-content: space-between;">
                                                       
                                                                <p>   1. Quality of classroom</p>
                                                                <div>
                                                                    @for ($i = 5; $i >= 1; $i--)
                                                                        <span id="existed-rating7-{{ $i }}"> 
                                                                            <input id='star7{{ $i }}' name='quality_classroom' type='radio'
                                                                                value='{{ $i }}'>
                                                                            <label for='star7{{ $i }}'><i class="las la-star fa-sm"></i></label>
                                                                        </span>
                                                                    @endfor
                                                                </div>
                                                    </div>              
                                                    <div class='give-rating' style="display: flex; justify-content: space-between;">
                                                                <p> 2. tests and checking </p>
                                                                <div>
                                                                    @for ($i = 5; $i >= 1; $i--)
                                                                        <span id="existed-rating8-{{ $i }}">
                                                                            <input id='star8{{ $i }}' name='tests' type='radio'
                                                                                value='{{ $i }}'>
                                                                            <label for='star8{{ $i }}'><i class="las la-star fa-sm"></i></label>
                                                                        </span>
                                                                    @endfor
                                                                </div>
                                                    </div>
                                                    <div class='give-rating' style="display: flex; justify-content: space-between;">
                                                                <p> 3. Quality of study  </p>
                                                                <div>
                                                                    @for ($i = 5; $i >= 1; $i--)
                                                                        <span id="existed-rating9-{{ $i }}">
                                                                            <input id='star9{{ $i }}' name='quality_study' type='radio'
                                                                                value='{{ $i }}'>
                                                                            <label for='star9{{ $i }}'><i class="las la-star fa-sm"></i></label>
                                                                        </span>
                                                                    @endfor
                                                                </div>
                                                    </div>          
                                                    <div class='give-rating' style="display: flex; justify-content: space-between;">
                                                                <p> 4. Current affairs  </p>
                                                                <div>
                                                                    @for ($i = 5; $i >= 1; $i--)
                                                                        <span id="existed-rating11-{{ $i }}">
                                                                            <input id='star11{{ $i }}' name='current_affair' type='radio'
                                                                                value='{{ $i }}'>
                                                                            <label for='star11{{ $i }}'><i class="las la-star fa-sm"></i></label>
                                                                        </span>
                                                                    @endfor
                                                                </div>
                                                    </div>          
                                                    <div class='give-rating' style="display: flex; justify-content: space-between;">
                                                                <p> 5. interview guidance program </p>
                                                                <div>
                                                                    @for ($i = 5; $i >= 1; $i--)
                                                                        <span id="existed-rating12-{{ $i }}">
                                                                            <input id='str12{{ $i }}' name='interview_guidance' type='radio'
                                                                                value='{{ $i }}'>
                                                                            <label for='str12{{ $i }}'><i class="las la-star fa-sm"></i></label>
                                                                        </span>
                                                                    @endfor
                                                                </div>
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
                        <form action="{{ route('user.delete.review') }}" method="POST">
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
        $(document).ready(function() {

            //update review
            $('.edit-review').on('click', function() {

                var result = $(this).data();
                // console.log('result', result);
                $('.edit-id').val(result.id);
                $('.edit-review12').val(result.review);

                $('#reviewUpdateModal').find('input[name=rating]').parent('span').removeClass('checked');
                $('#reviewUpdateModal').find('input[name=teaching_faculty]').parent('span').removeClass('checked');
                $('#reviewUpdateModal').find('input[name=infra_quality]').parent('span').removeClass('checked');
                $('#reviewUpdateModal').find('input[name=technology_friendly]').parent('span').removeClass('checked');
                $('#reviewUpdateModal').find('input[name=counseling_quality]').parent('span').removeClass('checked');
                $('#reviewUpdateModal').find('input[name=operational_manage]').parent('span').removeClass('checked');
                $('#reviewUpdateModal').find('input[name=attitude_management]').parent('span').removeClass('checked');
                $('#reviewUpdateModal').find('input[name=quality_classroom]').parent('span').removeClass('checked');
                $('#reviewUpdateModal').find('input[name=tests]').parent('span').removeClass('checked');
                $('#reviewUpdateModal').find('input[name=quality_study]').parent('span').removeClass('checked');
                $('#reviewUpdateModal').find('input[name=current_affair]').parent('span').removeClass('checked');
                $('#reviewUpdateModal').find('input[name=interview_guidance]').parent('span').removeClass('checked');
                var existRating = result.rating;
                var teaching_faculty = result.teaching_faculty;
                var infra_quality = result.infra_quality;
                var technology_friendly = result.technology_friendly;
                var counseling_quality = result.counseling_quality;
                var operational_manage = result.operational_manage;
                var attitude_management = result.attitude_management;
                var quality_classroom = result.quality_classroom;
                var tests = result.tests;
                var quality_study = result.quality_study;
                var current_affair = result.current_affair;
                var interview_guidance = result.interview_guidance;

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
                    $('#existed-rating6-5').addClass('checked');
                } else if (attitude_management == 4) {
                    $('#existed-rating6-4').addClass('checked');
                } else if (attitude_management == 3) {
                    $('#existed-rating6-3').addClass('checked');
                } else if (attitude_management == 2) {
                    $('#existed-rating6-2').addClass('checked');
                } else {
                    $('#existed-rating6-1').addClass('checked');
                }

                if (quality_classroom == 5) {
                    $('#existed-rating7-5').addClass('checked');
                } else if (quality_classroom == 4) {
                    $('#existed-rating7-4').addClass('checked');
                } else if (quality_classroom == 3) {
                    $('#existed-rating7-3').addClass('checked');
                } else if (quality_classroom == 2) {
                    $('#existed-rating7-2').addClass('checked');
                } else {
                    $('#existed-rating7-1').addClass('checked');
                }

                if (tests == 5) {
                    $('#existed-rating8-5').addClass('checked');
                } else if (tests == 4) {
                    $('#existed-rating8-4').addClass('checked');
                } else if (tests == 3) {
                    $('#existed-rating8-3').addClass('checked');
                } else if (tests == 2) {
                    $('#existed-rating8-2').addClass('checked');
                } else {
                    $('#existed-rating8-1').addClass('checked');
                }

                if (quality_study == 5) {
                    $('#existed-rating9-5').addClass('checked');
                } else if (quality_study == 4) {
                    $('#existed-rating9-4').addClass('checked');
                } else if (quality_study == 3) {
                    $('#existed-rating9-3').addClass('checked');
                } else if (quality_study == 2) {
                    $('#existed-rating9-2').addClass('checked');
                } else {
                    $('#existed-rating9-1').addClass('checked');
                }

                if (current_affair == 5) {
                    $('#existed-rating11-5').addClass('checked');
                } else if (current_affair == 4) {
                    $('#existed-rating11-4').addClass('checked');
                } else if (current_affair == 3) {
                    $('#existed-rating11-3').addClass('checked');
                } else if (current_affair == 2) {
                    $('#existed-rating11-2').addClass('checked');
                } else {
                    $('#existed-rating11-1').addClass('checked');
                }

                if (interview_guidance == 5) {
                    $('#existed-rating12-5').addClass('checked');
                } else if (interview_guidance == 4) {
                    $('#existed-rating12-4').addClass('checked');
                } else if (interview_guidance == 3) {
                    $('#existed-rating12-3').addClass('checked');
                } else if (interview_guidance == 2) {
                    $('#existed-rating12-2').addClass('checked');
                } else {
                    $('#existed-rating12-1').addClass('checked');
                }
            });

            //delete review
            $('.delete-review').on('click', function() {
                $('.delete-id').val($(this).data('id'));
            });

            //prime review Radio-box
            $(".give-rating input:radio").attr("checked", false);

            $(".give-rating input").click(function(e) {
                $(this).parent().siblings().removeClass("checked");
                $(this)
                    .parent()
                    .addClass("checked");
            });

            //update review Radio-box

            $(".give-rating-update input:radio").attr("checked", false);

            $(".give-rating-update input").click(function(e) {
                $(this).parent().siblings().removeClass("checked");
                $(this)
                    .parent()
                    .addClass("checked");
            });
        });
    </script>
@endpush
