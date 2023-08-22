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
                                    <th scope="col">@lang('Name')</th>
                                    <th scope="col">@lang('Icon')</th>
                                    <th scope="col">@lang('Status')</th>
                                    <th scope="col">@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($categories as $category)
                                    <tr>
                                        <td data-label="@lang('Name')">{{ @$category->name }}</td>
                                        <td data-label="@lang('Icon')">@php
                                            echo @$category->icon;
                                        @endphp</td>
                                        <td data-label="@lang('Status')">
                                            @if (@$category->status == 1)
                                                <span class="badge badge--success">@lang('Active')</span>
                                            @else
                                                <span class="badge badge--danger">@lang('Inactive')</span>
                                            @endif
                                        </td>
                                        <td data-label="@lang('Action')">
                                            <button class="icon-btn text--small editBtn" data-resource="{{ $category }}"><i class="las la-edit text--shadow"></i></button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table>

                            @if ($categories->hasPages())
                                {{ paginateLinks($categories) }}
                            @endif

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--Add Category Modal -->
    <div class="modal fade" id="addModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">@lang('Add New Category')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </button>
                </div>
                <form action="{{ route('admin.category.store') }}" method="POST">
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label>@lang('Name') <span class="text-danger">*</span></label>
                            <input type="text" name="name" value="{{ old('name') }}" class="form-control" required/>
                        </div>

                        <div class="form-group">
                            <label>@lang('Icon') <span class="text-danger">*</span></label>
                            <div class="input-group has_append">
                                <input type="text" class="form-control icon" name="icon" value="{{ old('icon') }}" required>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary iconPicker" data-icon="las la-home" role="iconpicker"></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--primary btn-block">@lang('Submit')</button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <!--Update Category Modal -->
    <div class="modal fade" id="updateModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">@lang('Edit Category')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label>@lang('Name')</label>
                            <input type="text" name="name" class="form-control"/>
                        </div>
                        <div class="form-group">
                            <label>@lang('Icon')</label>
                            <div class="input-group has_append">
                                <input type="text" class="form-control icon" name="icon" required>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary iconPicker" data-icon="las la-home"
                                        role="iconpicker"></button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">@lang('Status')</label>
                            <input type="checkbox" data-onstyle="-success" data-offstyle="-danger" data-height="40" data-toggle="toggle" data-on="@lang('Active')" data-off="@lang('Deactivate')" data-width="100%" name="status">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--primary btn-block">@lang('Submit')</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <button class="btn btn-sm btn--primary text--small" data-toggle="modal" data-target="#addModal">
        <i class="fa fa-fw fa-plus"></i>@lang('Add Category')
    </button>
@endpush
@push('script-lib')
    <script src="{{ asset('assets/admin/js/bootstrap-iconpicker.bundle.min.js') }}"></script>
@endpush
@push('script')
    <script>
        (function($) {
            $('.editBtn').on('click', function() {
                var modal = $('#updateModal');
                var resource = $(this).data('resource');
                modal.find('[name=name]').val(resource.name);
                modal.find('[name=icon]').val(resource.icon);

                if (resource.status == 1) {
                    modal.find('[name=status]').bootstrapToggle('on');
                } else {
                    modal.find('[name=status]').bootstrapToggle('off');
                }
                modal.find('form').attr('action', `{{ route('admin.category.update', '') }}/${resource.id}`);
                modal.modal('show');
            });


            $('.iconPicker').iconpicker().on('change', function(e) {
                $(this).parent().siblings('.icon').val(`<i class="${e.icon}"></i>`);
            });
        })(jQuery);
    </script>
@endpush
