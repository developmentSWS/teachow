@extends($activeTemplate.'layouts.frontend')
@section('content')
    <section class="pt-50 pb-50 contact-section overflow-hidden">
        <div class="shape-one"></div>
        <div class="shape-two"></div>
        <div class="shape-three"></div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="custom--card">
                        <div class="card-header bg--dark d-flex flex-wrap justify-content-between align-items-center">
                            <h5 class="text-white">
                                @if ($my_ticket->status == 0)
                                    <span class="badge badge--success py-2 px-3">@lang('Open')</span>
                                @elseif($my_ticket->status == 1)
                                    <span class="badge badge--primary py-2 px-3">@lang('Answered')</span>
                                @elseif($my_ticket->status == 2)
                                    <span class="badge badge--warning py-2 px-3">@lang('Replied')</span>
                                @elseif($my_ticket->status == 3)
                                    <span class="badge badge--dark py-2 px-3">@lang('Closed')</span>
                                @endif
                                [@lang('Ticket')#{{ $my_ticket->ticket }}] {{ $my_ticket->subject }}
                            </h5>
                            <button class="btn btn-danger close-button" type="button" title="@lang('Close Ticket')"
                                data-bs-toggle="modal" data-bs-target="#DelModal"><i class="fa fa-lg fa-times-circle"></i>
                            </button>
                        </div>
                        <div class="card-body">
                            @if ($my_ticket->status != 4)
                                <form method="post" action="{{ route('ticket.reply', $my_ticket->id) }}" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="replayTicket" value="1">
                                    <div class="justify-content-between">
                                        <div class="form-group">
                                            <textarea name="message" class="form--control " id="inputMessage" placeholder="@lang('Your Reply')" rows="4" cols="10"></textarea>
                                        </div>
                                    </div>
                                    <div class="row justify-content-between">
                                        <div class="col-lg-12">
                                            <div class="row justify-content-between">
                                                <div class="col-lg-12">
                                                    <label class="my-2 t-heading-font"
                                                        for="inputAttachments">@lang('Attachments')</label>
                                                    <div class="input-group mb-3">
                                                        <input type="file" name="attachments[]" class="form--control" id="inputAttachments" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                                                        <button type="button" class="input-group-text btn--base addFile border-0">
                                                            <i class="las la-plus"></i>
                                                        </button>
                                                    </div>
                                                    <div class="mt-2" id="fileUploadsContainer"></div>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-between">
                                                <small class="m-2 ticket-attachments-message text-muted">
                                                    @lang('Allowed File Extensions'): .@lang('jpg'), .@lang('jpeg'),
                                                    .@lang('png'), .@lang('pdf'), .@lang('doc'), .@lang('docx')
                                                </small>

                                            </div>
                                        </div>
                                    </div>

                                    <button class="btn btn--base w-100 mt-3" type="submit">
                                        <i class="lab la-telegram-plane"></i>@lang('Reply')
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>


                    <div class="custom--card mt-4">
                        <div class="card-body">
                            <div class="col-md-12">
                                @foreach ($messages as $message)
                                    @if ($message->admin_id == 0)
                                        <div class="row border border-primary border-radius-3 my-3 py-3 mx-2">
                                            <div class="col-md-3 border-right text-right">
                                                <h6 class="my-3">{{ $message->ticket->name }}</h6>
                                            </div>
                                            <div class="col-md-9">
                                                <small class="text--secondary font-weight-bold my-3">
                                                    @lang('Posted on') {{ $message->created_at->format('l, jS F Y @ H:i') }}</small>
                                                <br>
                                                <p>{{ $message->message }}</p>
                                                @if ($message->attachments->count() > 0)
                                                    <div class="mt-2">
                                                        @foreach ($message->attachments as $k => $image)
                                                            <a href="{{ route('ticket.download', encrypt($image->id)) }}"
                                                                class="mr-3 text--base"><i class="fa fa-file"></i>
                                                                @lang('Attachment') {{ ++$k }} </a>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @else
                                        <div class="row border border-warning border-radius-3 my-3 py-3 mx-2"
                                            style="background-color: #ffd96729">
                                            <div class="col-md-3 border-right text-right">
                                                <h5 class="my-3">{{ $message->admin->name }}</h5>
                                                <p class="lead text-muted">@lang('Staff')</p>
                                            </div>
                                            <div class="col-md-9">
                                                <small class="text-muted font-weight-bold my-3">
                                                    @lang('Posted on') {{ $message->created_at->format('l, dS F Y @ H:i') }}</small>
                                                <br>
                                                <p>{{ $message->message }}</p>
                                                @if ($message->attachments->count() > 0)
                                                    <div class="mt-2">
                                                        @foreach ($message->attachments as $k => $image)
                                                            <a href="{{ route('ticket.download', encrypt($image->id)) }}" class="mr-3"><i class="fa fa-file"></i>
                                                                @lang('Attachment') {{ ++$k }}
                                                            </a>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>

                        </div>
                    </div>
                </div>
            </div>


        </div>
    </section>
    <!-- delete Modal -->
    <div class="modal fade" id="DelModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="{{ route('ticket.reply', $my_ticket->id) }}">
                    @csrf
                    <input type="hidden" name="replayTicket" value="2">
                    <div class="modal-header">
                        <h5 class="modal-title"> @lang('Confirmation Alert')</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <strong class="text-dark">@lang('Are you sure to close this support ticket')?</strong>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark btn-sm" data-bs-dismiss="modal">
                            @lang('No')
                        </button>
                        <button type="submit" class="btn btn--base btn-sm">
                            @lang("Yes")
                        </button>
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
            $('.delete-message').on('click', function(e) {
                $('.message_id').val($(this).data('id'));
            });
            $('.addFile').on('click', function() {
                $("#fileUploadsContainer").append(
                    `<div class="input-group mb-3">
                        <input type="file" name="attachments[]" class="form--control" id="inputAttachments"aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" required>
                        <button type="button" class="input-group-text btn--danger border-0 remove-btn"> <i class="las la-times"></i></button>
                    </div>`
                )
            });
            $(document).on('click', '.remove-btn', function() {
                $(this).closest('.input-group').remove();
            });
        })(jQuery);
    </script>
@endpush
