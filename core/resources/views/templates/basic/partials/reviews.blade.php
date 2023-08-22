@php $addShowAfterColum = 3; @endphp

@forelse ($reviews as $k => $review)
    <div class="review-block">
        <p class="mb-2 mt-4">
            @lang('Review of') <a href="{{ route('company.details', [$review->company_id, slug($review->company->name)]) }}" class="font-weight-bold text--base">{{ __($review->company->name) }}</a>
        </p>
        <div class="customer-review">
            <div class="customer-review__thumb">
                <img src="{{ getImage(imagePath()['profile']['user']['path'] . '/' . auth()->user()->image,imagePath()['profile']['user']['size']) }}"
                    alt="image">
            </div>
            <div class="customer-review__content">
                <div class="customer-review__header">
                    <div class="left">
                        <h6>{{ auth()->user()->fullname }}</h6>
                        <span><i class="las la-map-marker-alt"></i>{{ auth()->user()->address->country }}</span>
                    </div>
                    <div class="right">
                        <div class="ratings d-flex align-items-center justify-content-end">
                            @php
                                echo rating($review->rating);
                            @endphp
                        </div>
                    </div>
                </div>
                <div class="customer-review__body">
                    <p>{{ __($review->review) }}</p>
                </div>
                <div class="customer-review__footer">
                    <div class="left">
                        <ul class="customer-review__action-list">
                            <li>
                                <button class="edit-review" type="button" data-bs-toggle="modal" data-bs-target="#reviewUpdateModal" data-resource="{{ $review }}" data-img="{{ getImage(imagePath()['company']['path'] . '/' . $review->company->image, imagePath()['company']['size']) }}"><i class="las la-edit"></i>
                                    @lang('Edit Review')
                                </button>
                            </li>
                        </ul>
                    </div>
                    <div class="right">
                        <ul class="customer-review__action-list">
                            <li>
                                <button class="delete-review" type="button" data-bs-toggle="modal" data-bs-target="#reviewDeleteModal"
                                data-id="{{ $review->id }}"><i class="las la-trash-alt"></i>@lang('Delete')</button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- advertisement Block -->
    @if ($k + 1 == $addShowAfterColum)
        @php
            $addShowAfterColum += 3;
        @endphp
        <div class="my-3">
            @php
                echo getAdvertisement('728x90');
            @endphp
        </div>
    @endif

@empty
    <div class="bg-white p-5 rounded">
        <h5 class="text-center"> @lang('No review yet')</h5>
    </div>
@endforelse
@if ($reviews->hasPages())
<div class="col-12 mt-1">
    <ul class="list list--row justify-content-center align-items-center">
        {{ paginateLinks($reviews) }}
    </ul>
</div>
@endif

@if(count($reviews) > 0)
<!-- review update modal -->
<div class="modal fade" id="reviewUpdateModal" tabindex="-1" aria-labelledby="reviewUpdateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reviewUpdateModalLabel">@lang('Update Review')</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('user.update.review') }}" method="POST">
                    @csrf
                    <div class="row align-items-center mb-3">
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
                                                <div class="card-header text-center"> Deliverables  </div>
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
                    <textarea name="review" class="form--control edit-review12"
                        placeholder="@lang('Write your review')"></textarea>
                    <div class="text-end">
                        <button type="submit" class="btn btn--base w-100">@lang('Update')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endif



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
