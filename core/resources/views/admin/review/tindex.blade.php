@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th scope="col">@lang('S.N.')</th>
                                    <th scope="col">@lang('Review')</th>
                                    <th scope="col">@lang('Teacher')</th>
                                    <th scope="col">@lang('Username')</th>
                                    <th scope="col">@lang('Rating')</th>
                                    <th scope="col">@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($reviews as $review)
                                @php $teacher = App\Models\Teacher::where('id', $review->teacher_id)->first(); @endphp
                                    <tr>
                                        <td data-label="@lang('S.N.')">{{ $loop->iteration }}</td>
                                        <td data-label="@lang('Review')" class="showReview"
                                            data-review="{{ $review->review }}">
                                            {{ shortDescription(@$review->review, 35) }}</td>
                                        <td data-label="@lang('Company')">{{ !empty($teacher->name) ? $teacher->name : '' }}</td>
                                        <td data-label="@lang('User')">{{ @$review->user->username }}</td>
                                        <td data-label="@lang('Rating')">
                                            <span class="text--orange"> @php
                                                echo rating(@$review->rating);
                                            @endphp</span>

                                        </td>

                                        <td data-label="@lang('Action')">
                                            <button class="icon-btn text--small showReview"
                                                data-review="{{ $review->review }}"><i
                                                    class="las la-eye text--shadow"></i></button>
                                            <button class="icon-btn btn--danger text--small deleteReview"
                                                data-id="{{ $review->id }}"  data-company_id="{{ !empty($teacher->id) ? $teacher->id : '0' }}"><i
                                                    class="las la-trash text--shadow "></i></button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>
                </div>


                @if ($reviews->hasPages())
                <div class="card-footer">
                    {{ paginateLinks($reviews) }}
                </div>
                @endif
            </div>
        </div>
    </div>


    <!--show Review Modal -->
    <div class="modal fade" id="showReview">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">@lang('Review')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </button>
                </div>
                <div class="modal-body show-review"></div>
                <div class="modal-footer">
                    <button type="submit" data-dismiss="modal" class="btn btn--danger">@lang('Cancel')</button>
                </div>
            </div>
        </div>
    </div>

    <!--Delete Review -->
    <div class="modal fade" id="deleteReview">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">@lang('Review Delete Confirmation')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @lang('Are you sure to delete this review?')
                </div>
                <div class="modal-footer">
                    <form action="{{ route('admin.treview.adelete') }}" method="post">
                        @csrf
                        <input type="hidden" value="" name="review_id">
                        <input type="hidden" value="" name="company_id">
                        <button data-dismiss="modal" class="btn btn--dark">@lang('No')</button>
                        <button type="submit" class="btn btn--primary">@lang('Yes')</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
@push('breadcrumb-plugins')
    <form method="GET" class="form-inline float-sm-right bg--white mb-2">
        <div class="input-group has_append">
            <input type="text" name="search" class="form-control" placeholder="@lang('Username/Company/Review')"
                value="{{ request()->search ?? '' }}">
            <div class="input-group-append">
                <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
            </div>
        </div>
    </form>
@endpush
@push('script')
    <script>
        (function($) {
            $('.showReview').on('click', function() {
                var modal = $('#showReview');
                $(".show-review").text($(this).data('review'))
                modal.modal('show');
            });
            $('.deleteReview').on('click', function() {
                var modal = $('#deleteReview');
                $("[name='review_id']").val($(this).data('id'))
                $("[name='company_id']").val($(this).data('company_id'))
                modal.modal('show');
            });
        })(jQuery);
    </script>
@endpush
