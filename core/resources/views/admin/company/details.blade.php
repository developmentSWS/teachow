@extends('admin.layouts.app')

@section('panel')
    <div class="row mb-none-30 justify-content-center">
        <div class="col-6 mb-30">
            <div class="card b-radius--10 overflow-hidden box--shadow1">
                <div class="card-body">
                    <h5 class="mb-20 text-muted d-flex justify-content-center">
                        <span class="font-weight-bold">@lang('Company Name :')&nbsp;</span>{{ __(@$company->name) }}
                    </h5>
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="font-weight-bold"> @lang('Create Date')</span>
                            {{ showDateTime($company->created_at) }}
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="font-weight-bold">@lang('User Name')</span>
                            <span class="font-weight-bold">
                                <a
                                    href="{{ route('admin.users.detail', $company->user_id) }}">{{ @$company->user->username }}</a>
                            </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="font-weight-bold">@lang('E-mail')</span>
                            <span class="font-weight-bold">{{ $company->email }}
                            </span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="font-weight-bold"> @lang('Website Link')</span>
                            <a href="{{ $company->url }}">{{ $company->url }}</a>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="font-weight-bold">@lang('Status')</span>
                            @php echo $company->statusText @endphp
                        </li>

                        @if ($company->admin_feedback)
                            <li class="list-group-item">
                                <strong>@lang('Admin Feedback')</strong>
                                <br>
                                <p>{{ $company->admin_feedback }}</p>
                            </li>
                        @endif
                    </ul>
                    @if ($company->status == 0)
                        <div class="row mt-4">
                            <div class="col-md-12 d-flex justify-content-end">
                                <button class="btn btn--success ml-1 approveBtn" data-toggle="tooltip"
                                    data-title="@lang('Approve')" data-id="{{ $company->id }}"
                                    data-name="{{ $company->name }}">
                                    <i class="fas la-check"></i> @lang('Approve')
                                </button>

                                <button class="btn btn--danger ml-1 rejectBtn" data-toggle="tooltip"
                                    data-original-title="@lang('Reject')" data-id="{{ $company->id }}"
                                    data-name="{{ $company->name }}">
                                    <i class="fas fa-ban"></i> @lang('Reject')
                                </button>
                            </div>
                        </div>
                    @endif
                    @if ($company->status == 1)
                        <div class="row mt-4">
                            <div class="col-md-12 d-flex justify-content-end">
                                     <button class="btn btn--danger ml-1 rejectBtn" data-toggle="tooltip"
                                    data-original-title="@lang('Reject')" data-id="{{ $company->id }}"
                                    data-name="{{ $company->name }}">
                                    <i class="fas fa-ban"></i> @lang('Reject')
                                </button>
                            </div>
                        </div>
                    @endif
                    @if ($company->status == 2)
                    <div class="row mt-4">
                            <div class="col-md-12 d-flex justify-content-end">
                                  <button class="btn btn--success ml-1 approveBtn" data-toggle="tooltip"
                                    data-title="@lang('Approve')" data-id="{{ $company->id }}"
                                    data-name="{{ $company->name }}">
                                    <i class="fas la-check"></i> @lang('Approve')
                                </button>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- APPROVE MODAL --}}
    <div id="approveModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Approval confirmation of ')<span class="company-name"></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.company.approve') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id">
                    <div class="modal-body">
                        <strong>@lang('Have you sent approval info')?</strong>
                        <textarea name="details" class="form-control pt-3" rows="3"
                            placeholder="@lang('Provide the details. eg: of approval!')" required=""></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn--success">@lang('Approve')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- REJECT MODAL --}}
    <div id="rejectModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Rejection confirmation of ')<span class="company-name"></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.company.reject') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id">
                    <div class="modal-body">
                        <strong>@lang('Have you sent Rejection info')?</strong>
                        <textarea name="details" class="form-control pt-3" rows="3"
                            placeholder="@lang('Provide the Details of rejection!')" required=""></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn--danger">@lang('Reject')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        (function($) {
            "use strict";
            $('.approveBtn').on('click', function() {
                var modal = $('#approveModal');
                modal.find('input[name=id]').val($(this).data('id'));
                modal.find('.company-name').text($(this).data('name'));
                modal.modal('show');
            });

            $('.rejectBtn').on('click', function() {
                var modal = $('#rejectModal');
                modal.find('input[name=id]').val($(this).data('id'));
                modal.find('.company-name').text($(this).data('name'));
                modal.modal('show');
            });
            $('.pendingBtn').on('click', function() {
                var modal = $('#pendingModal');
                modal.find('input[name=id]').val($(this).data('id'));
                modal.find('.company-name').text($(this).data('name'));
                modal.modal('show');
            });
        })(jQuery);
    </script>
@endpush
