@extends('admin.layouts.app')

@section('panel')
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th>@lang('S.N.')</th>
                                    <th>@lang('User')</th>
                                    <th>@lang('Name')</th>
                                    <th>@lang('Category')</th>
                                    <th>@lang('URL')</th>
                                    <th>@lang('Email')</th>

                                    @if(request()->routeIs('admin.company.index'))
                                    <th>@lang('Status')</th>
                                    @endif
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($companies as $company)

                                    <tr>
                                        <td data-label="@lang('S.N.')">
                                            {{ $companies->firstItem() + $loop->index }}
                                        </td>
                                        <td data-label="@lang('User')">
                                            <span class="font-weight-bold">
                                                <a href="{{ route('admin.users.detail', $company->user_id) }}" class="text--info">{{ $company->user->username }} </a>
                                            </span>
                                        </td>
                                        <td data-label="@lang('Name')"><strong>{{ __($company->name) }}</strong></td>
                                        <td data-label="@lang('Category')">
                                            <strong>{{ __($company->category->name) }}</strong>
                                        </td>
                                        <td data-label="@lang('URL')"><strong>{{ __($company->url) }}</strong></td>

                                        <td data-label="@lang('Email')"><strong>{{ __($company->email) }}</strong></td>

                                        @if(request()->routeIs('admin.company.index'))
                                            <td data-label="@lang('Status')">
                                                @php echo $company->statusText @endphp
                                            </td>
                                        @endif

                                        <td data-label="@lang('Action')">
                                            <a href="{{ route('admin.company.details', $company->id) }}" class="icon-btn ml-1" data-toggle="tooltip" data-original-title="@lang('Detail')">
                                                <i class="la la-desktop"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse
                            </tbody>

                        </table><!-- table end -->
                    </div>
                </div>

                @if($companies->hasPages())
                <div class="card-footer py-4">
                    {{ paginateLinks($companies) }}
                </div>
                @endif
            </div><!-- card end -->
        </div>
    </div>
@endsection


@push('breadcrumb-plugins')
    <form method="GET" class="form-inline float-sm-right bg--white mb-2">
        <div class="input-group has_append">
            <input type="text" name="search" class="form-control" placeholder="@lang('Company/Category')"
                value="{{ request()->search ?? '' }}">
            <div class="input-group-append">
                <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
            </div>
        </div>
    </form>
@endpush
