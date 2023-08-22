@php $addShowAfterColum = 3; @endphp

@forelse ($treviews as $k => $review)
    <div class="review-block">
        <p class="mb-2 mt-4">
            @lang('Review of') <a href="{{ route('company.details', [$review->teacher_id, slug($review->teacher->name)]) }}" class="font-weight-bold text--base">{{ __($review->teacher->name) }}</a>
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
                                <button class="edit-review-teacher" type="button" data-bs-toggle="modal" data-bs-target="#reviewUpdateModal12" data-resource="{{ $review }}" data-img="{{ getImage(imagePath()['company']['path'] . '/' . $review->teacher->image, imagePath()['company']['size']) }}"><i class="las la-edit"></i>
                                    @lang('Edit Review')
                                </button>
                            </li>
                        </ul>
                    </div>
                    <div class="right">
                        <ul class="customer-review__action-list">
                            <li>
                                <button class="delete-review" type="button" data-bs-toggle="modal" data-bs-target="#reviewDeleteModal12"
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


<!-- review update modal -->
<div class="modal fade" id="reviewUpdateModal12" tabindex="-1" aria-labelledby="reviewUpdateModal12Label" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reviewUpdateModal12Label">@lang('Update Review')</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form action="{{ route('user.update.teacher.review') }}" method="POST">
                            @csrf
                            <div class="row mt-4">
                                        <div class="col-sm-12">
                                            <div class="card" style="height: 150px;">
                                                <div class="card-header text-center"> Overall - </div>
                                                <div class="card-body" style="display: flex; justify-content: center; align-items:center;">
                                                    <div class='give-rating1'>
                                                        @for ($i = 5; $i >= 1; $i--)
                                                            <span id="existed1-rating-{{ $i }}">
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
                                                <div class="card-header text-center" style="height: 100px; display: flex; justify-content: center; align-items: center;"> Friendliness of teaching pedagogy (Positive teaching-learning environment in class)</div>
                                                <div class="card-body" style="display: flex; justify-content: center; align-items:center;">
                                                    <div class='give-rating1'>
                                                        @for ($i = 5; $i >= 1; $i--)
                                                            <span id="existed1-rating1-{{ $i }}">
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
                                                <div class="card-header text-center" style="height: 100px; display: flex; justify-content: center; align-items: center;"> Clarity of concept taught (capacity to simplify complex concepts and explain them)</div>
                                                <div class="card-body" style="display: flex; justify-content: center; align-items:center;">
                                                    <div class='give-rating1'>
                                                        @for ($i = 5; $i >= 1; $i--)
                                                            <span id="existed1-rating2-{{ $i }}">
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
                                                <div class="card-header text-center" style="height: 100px; display: flex; justify-content: center; align-items: center;"> Communication Skills - command and fluency over teaching language </div>
                                                <div class="card-body" style="display: flex; justify-content: center; align-items:center;">
                                                    <div class='give-rating1'>
                                                        @for ($i = 5; $i >= 1; $i--)
                                                            <span id="existed1-rating3-{{ $i }}"> 
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
                                                <div class="card-header text-center" style="height: 100px; display: flex; justify-content: center; align-items: center;"> Student engagement in class/attention to doubt solving </div>
                                                <div class="card-body" style="display: flex; justify-content: center; align-items:center;">
                                                    <div class='give-rating1'>
                                                        @for ($i = 5; $i >= 1; $i--)
                                                            <span id="existed1-rating4-{{ $i }}">
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
                                                <div class="card-header text-center" style="height: 70px; display: flex; justify-content: center; align-items: center;"> Punctuality</div>
                                                <div class="card-body" style="display: flex; justify-content: center; align-items:center;">
                                                    <div class='give-rating1'>
                                                        @for ($i = 5; $i >= 1; $i--)
                                                            <span id="existed1-rating5-{{ $i }}">
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
                                                <div class="card-header text-center"> Syllabus completed as per communicated commitment at the start of the course  - </div>
                                                <div class="card-body" style="display: flex; justify-content: center; align-items:center;">
                                                    <div class='give-rating1'>
                                                        @for ($i = 5; $i >= 1; $i--)
                                                            <span id="existed1-rating6-{{ $i }}">
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
                                                <div class="card-header text-center"> Content validity : Previous year questions and/or solvable through class teaching (* except questions related to current affairs - previous year's questions may not be very valid for the current year )</div>
                                                <div class="card-body" style="display: flex; justify-content: center; align-items:center;">
                                                    <div class='give-rating1'>
                                                        @for ($i = 5; $i >= 1; $i--)
                                                            <span id="existed1-rating7-{{ $i }}">
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
                            <input type="hidden" class="edit-id1" value="" name="id">
                            <textarea name="review" class="form--control edit-review123 mt-3"
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
<div class="modal fade" id="reviewDeleteModal12" tabindex="-1" aria-labelledby="reviewDeleteModalLabel"
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
