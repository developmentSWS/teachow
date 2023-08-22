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
                                    <th>@lang('Institute/Teacher')</th>
                                    <th>@lang('Type')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Document')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($claimLists as $company)
                                    <tr>
                                        <td data-label="@lang('S.N.')">
                                            {{ $claimLists->firstItem() + $loop->index }}
                                        </td>
                                        <td data-label="@lang('User')">
                                            <span class="font-weight-bold">
                                                <a href="{{ route('admin.users.detail', $company->user_id) }}" class="text--info">{{ $company->user_name }} </a>
                                            </span>
                                        </td>
                                        <td data-label="@lang('Name')"><strong>
                                            @if($company->type == "teacher")
                                            <a href="{{ route('admin.teacher.details', $company->t_i_id) }}" >
                                                {{ $company->teacher }}
                                            </a>
                                            @else 
                                            <a href="{{ route('admin.company.details', $company->t_i_id) }}" >
                                                {{ $company->teacher }}
                                            </a>
                                            @endif
                                        </strong></td>
                                       
                                        <td data-label="@lang('Email')"><strong>{{ $company->type }}</strong></td>
                                        <td data-label="@lang('Email')"><strong>
                                            @if($company->status == 1)
                                              <span class="badge badge-success"> {{ ('Approved') }}</span> 
                                            @elseif($company->status == 2)
                                            <span class="badge badge-danger"> {{ ('Rejected') }}</span> 
                                            @else 
                                            <span class="badge badge-info"> {{ ('Pending') }}</span> 
                                            @endif
                                        </strong></td>
                                        <td>
                                            <a href="{{ getImage(imagePath()['company']['path'] . '/' . $company->document) }}" target="_blank">View Document</a>
                                        
                                        </td>
                                        <td data-label="@lang('Action')">
                                            @if($company->status != 1)
                                            <a href="{{ route('admin.claim.approve', $company->id) }}" onclick="return confirm('Are You Sure!');" class="btn btn-sm btn-info ml-1" data-toggle="tooltip" data-original-title="@lang('Approve')">
                                                <i class="la la-check"></i>
                                            </a>
                                            <a href="{{ route('admin.claim.reject', $company->id) }}" onclick="return confirm('Are You Sure!');" class="btn btn-sm btn-success ml-1" data-toggle="tooltip" data-original-title="@lang('Reject')">
                                                <i class="la la-ban"></i>
                                            </a>
                                            <a href="{{ route('admin.claim.delete', $company->id) }}" onclick="return confirm('Are You Sure! Because This operation can not be reversible');" class="btn btn-sm btn-danger ml-1" data-toggle="tooltip" data-original-title="@lang('Delete')">
                                                <i class="la la-trash"></i>
                                            </a>
                                            @else 
                                                {{ 'Approved Request' }}
                                            @endif
                                            

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

                @if($claimLists->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($claimLists) }}
                    </div>
                @endif
            </div><!-- card end -->
        </div>
    </div>
@endsection


@push('breadcrumb-plugins')
    <form method="GET" class="form-inline float-sm-right bg--white mb-2">
        <div class="input-group has_append">
            <input type="text" name="search" class="form-control" placeholder="@lang('teacher')"
                value="{{ request()->search ?? '' }}">
            <div class="input-group-append">
                <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
            </div>
        </div>
    </form>
@endpush
