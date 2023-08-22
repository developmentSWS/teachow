@extends('admin.layouts.app')

@section('panel')
   
  
    <div class="row mb-none-30">

        <div class="col-xl-3 col-lg-4 col-sm-6 mb-30">
            <div class="dashboard-w1 bg--info b-radius--10 box-shadow">
                <div class="icon">
                    <i class="la la-bank"></i>
                </div>
                <div class="details">
                    <div class="numbers">
                        <span class="amount">{{ $widget['total_companies'] }}</span>
                    </div>
                    <div class="desciption">
                        <span class="text--small">@lang('Total Institute\'s')</span>
                    </div>
                    <a href="{{ route('admin.company.index') }}"
                        class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View All')</a>
                </div>
            </div>
        </div><!-- dashboard-w1 end -->
        <div class="col-xl-3 col-lg-4 col-sm-6 mb-30">
            <div class="dashboard-w1 bg--success b-radius--10 box-shadow">
                <div class="icon">
                    <i class="las la-thumbs-up"></i>
                </div>
                <div class="details">
                    <div class="numbers">
                        <span class="amount">{{ $widget['total_approved_companies'] }}</span>
                    </div>
                    <div class="desciption">
                        <span class="text--small">@lang('Total Approved Institute\'s')</span>
                    </div>
                    <a href="{{ route('admin.company.approved') }}"
                        class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View All')</a>
                </div>
            </div>
        </div><!-- dashboard-w1 end -->
        <div class="col-xl-3 col-lg-6 col-sm-6 mb-30">
            <div class="dashboard-w1 bg--warning b-radius--10 box-shadow">
                <div class="icon">
                    <i class="las la-pause-circle"></i>
                </div>
                <div class="details">
                    <div class="numbers">
                        <span class="amount">{{ $widget['total_pending_companies'] }}</span>
                    </div>
                    <div class="desciption">
                        <span>@lang('Total Pending Institute\'s')</span>
                    </div>
                    <a href="{{ route('admin.company.pending') }}"
                        class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View All')</a>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-sm-6 mb-30">
            <div class="dashboard-w1 bg--5 b-radius--10 box-shadow">
                <div class="icon">
                    <i class="las la-ban"></i>
                </div>
                <div class="details">
                    <div class="numbers">
                        <span class="amount">{{ $widget['total_rejected_companies'] }}</span>
                    </div>
                    <div class="desciption">
                        <span>@lang('Total Rejected Institute\'s')</span>
                    </div>
                    <a href="{{ route('admin.company.rejected') }}"
                        class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View All')</a>
                </div>
            </div>
        </div>
    </div><!-- row end-->

    <div class="row mt-50 mb-none-30">

<div class="col-xl-3 col-lg-4 col-sm-6 mb-30">
    <div class="dashboard-w1 bg--info b-radius--10 box-shadow">
        <div class="icon">
            <i class="la la-bank"></i>
        </div>
        <div class="details">
            <div class="numbers">
                <span class="amount">{{ $widget['total_teacher'] }}</span>
            </div>
            <div class="desciption">
                <span class="text--small">@lang('Total Teacher\'s')</span>
            </div>
            <a href="{{ route('admin.teacher.index') }}"
                class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View All')</a>
        </div>
    </div>
</div><!-- dashboard-w1 end -->
<div class="col-xl-3 col-lg-4 col-sm-6 mb-30">
    <div class="dashboard-w1 bg--success b-radius--10 box-shadow">
        <div class="icon">
            <i class="las la-thumbs-up"></i>
        </div>
        <div class="details">
            <div class="numbers">
                <span class="amount">{{ $widget['total_approved_teacher'] }}</span>
            </div>
            <div class="desciption">
                <span class="text--small">@lang('Total Approved Teacher\'s')</span>
            </div>
            <a href="{{ route('admin.teacher.approved') }}"
                class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View All')</a>
        </div>
    </div>
</div><!-- dashboard-w1 end -->
<div class="col-xl-3 col-lg-6 col-sm-6 mb-30">
    <div class="dashboard-w1 bg--warning b-radius--10 box-shadow">
        <div class="icon">
            <i class="las la-pause-circle"></i>
        </div>
        <div class="details">
            <div class="numbers">
                <span class="amount">{{ $widget['total_pending_teacher'] }}</span>
            </div>
            <div class="desciption">
                <span>@lang('Total Pending Teacher\'s')</span>
            </div>
            <a href="{{ route('admin.teacher.pending') }}"
                class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View All')</a>
        </div>
    </div>
</div>
<div class="col-xl-3 col-lg-6 col-sm-6 mb-30">
    <div class="dashboard-w1 bg--5 b-radius--10 box-shadow">
        <div class="icon">
            <i class="las la-ban"></i>
        </div>
        <div class="details">
            <div class="numbers">
                <span class="amount">{{ $widget['total_rejected_teacher'] }}</span>
            </div>
            <div class="desciption">
                <span>@lang('Total Rejected Teacher\'s')</span>
            </div>
            <a href="{{ route('admin.teacher.rejected') }}"
                class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View All')</a>
        </div>
    </div>
</div>
</div>

    <div class="row mt-50 mb-none-30">
        <div class="col-xl-3 col-lg-4 col-sm-6 mb-30">
            <div class="dashboard-w1 bg--primary b-radius--10 box-shadow">
                <div class="icon">
                    <i class="fa fa-users"></i>
                </div>
                <div class="details">
                    <div class="numbers">
                        <span class="amount">{{ $widget['total_users'] }}</span>
                    </div>
                    <div class="desciption">
                        <span class="text--small">@lang('Total Users')</span>
                    </div>
                    <a href="{{ route('admin.users.all') }}"
                        class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View All')</a>
                </div>
            </div>
        </div><!-- dashboard-w1 end -->
        <div class="col-xl-3 col-lg-4 col-sm-6 mb-30">
            <div class="dashboard-w1 bg--green b-radius--10 box-shadow">
                <div class="icon">
                    <i class="fa fa-user-check"></i>
                </div>
                <div class="details">
                    <div class="numbers">
                        <span class="amount">{{ $widget['total_active_users'] }}</span>
                    </div>
                    <div class="desciption">
                        <span class="text--small">@lang('Total Active Users')</span>
                    </div>
                    <a href="{{ route('admin.users.active') }}"
                        class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View All')</a>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-4 col-sm-6 mb-30">
            <div class="dashboard-w1 bg--red b-radius--10 box-shadow ">
                <div class="icon">
                    <i class="la la-comment-slash"></i>
                </div>
                <div class="details">
                    <div class="numbers">
                        <span class="amount">{{ $widget['total_email_unverified_users'] }}</span>
                    </div>
                    <div class="desciption">
                        <span class="text--small">@lang('Total Email Unverified Users')</span>
                    </div>
                    <a href="{{ route('admin.users.email.unverified') }}"
                        class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View All')</a>
                </div>
            </div>
        </div><!-- dashboard-w1 end -->
        <div class="col-xl-3 col-lg-4 col-sm-6 mb-30">
            <div class="dashboard-w1 bg--danger b-radius--10 box-shadow ">
                <div class="icon">
                    <i class="las la-phone-slash"></i>
                </div>
                <div class="details">
                    <div class="numbers">
                        <span class="amount">{{ $widget['total_sms_unverified_users'] }}</span>
                    </div>
                    <div class="desciption">
                        <span class="text--small">@lang('Total SMS Unverified Users')</span>
                    </div>

                    <a href="{{ route('admin.users.sms.unverified') }}"
                        class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View All')</a>
                </div>
            </div>
        </div><!-- dashboard-w1 end -->
    </div>

    <div class="row mb-none-30 mt-5">
        <div class="col-xl-4 col-lg-6 mb-30">
            <div class="card overflow-hidden">
                <div class="card-body">
                    <h5 class="card-title">@lang('Login By Browser')</h5>
                    <canvas id="userBrowserChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-6 mb-30">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">@lang('Login By OS')</h5>
                    <canvas id="userOsChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-6 mb-30">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">@lang('Login By Country')</h5>
                    <canvas id="userCountryChart"></canvas>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="{{ asset('assets/admin/js/vendor/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/vendor/chart.js.2.8.0.js') }}"></script>

    <script>
        "use strict";


        var ctx = document.getElementById('userBrowserChart');
        var myChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: @json($chart['user_browser_counter']->keys()),
                datasets: [{
                    data: {{ $chart['user_browser_counter']->flatten() }},
                    backgroundColor: [
                        '#ff7675',
                        '#6c5ce7',
                        '#ffa62b',
                        '#ffeaa7',
                        '#D980FA',
                        '#fccbcb',
                        '#45aaf2',
                        '#05dfd7',
                        '#FF00F6',
                        '#1e90ff',
                        '#2ed573',
                        '#eccc68',
                        '#ff5200',
                        '#cd84f1',
                        '#7efff5',
                        '#7158e2',
                        '#fff200',
                        '#ff9ff3',
                        '#08ffc8',
                        '#3742fa',
                        '#1089ff',
                        '#70FF61',
                        '#bf9fee',
                        '#574b90'
                    ],
                    borderColor: [
                        'rgba(231, 80, 90, 0.75)'
                    ],
                    borderWidth: 0,

                }]
            },
            options: {
                aspectRatio: 1,
                responsive: true,
                maintainAspectRatio: true,
                elements: {
                    line: {
                        tension: 0 // disables bezier curves
                    }
                },
                scales: {
                    xAxes: [{
                        display: false
                    }],
                    yAxes: [{
                        display: false
                    }]
                },
                legend: {
                    display: false,
                }
            }
        });



        var ctx = document.getElementById('userOsChart');
        var myChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: @json($chart['user_os_counter']->keys()),
                datasets: [{
                    data: {{ $chart['user_os_counter']->flatten() }},
                    backgroundColor: [
                        '#ff7675',
                        '#6c5ce7',
                        '#ffa62b',
                        '#ffeaa7',
                        '#D980FA',
                        '#fccbcb',
                        '#45aaf2',
                        '#05dfd7',
                        '#FF00F6',
                        '#1e90ff',
                        '#2ed573',
                        '#eccc68',
                        '#ff5200',
                        '#cd84f1',
                        '#7efff5',
                        '#7158e2',
                        '#fff200',
                        '#ff9ff3',
                        '#08ffc8',
                        '#3742fa',
                        '#1089ff',
                        '#70FF61',
                        '#bf9fee',
                        '#574b90'
                    ],
                    borderColor: [
                        'rgba(0, 0, 0, 0.05)'
                    ],
                    borderWidth: 0,

                }]
            },
            options: {
                aspectRatio: 1,
                responsive: true,
                elements: {
                    line: {
                        tension: 0 // disables bezier curves
                    }
                },
                scales: {
                    xAxes: [{
                        display: false
                    }],
                    yAxes: [{
                        display: false
                    }]
                },
                legend: {
                    display: false,
                }
            },
        });


        // Donut chart
        var ctx = document.getElementById('userCountryChart');
        var myChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: @json($chart['user_country_counter']->keys()),
                datasets: [{
                    data: {{ $chart['user_country_counter']->flatten() }},
                    backgroundColor: [
                        '#ff7675',
                        '#6c5ce7',
                        '#ffa62b',
                        '#ffeaa7',
                        '#D980FA',
                        '#fccbcb',
                        '#45aaf2',
                        '#05dfd7',
                        '#FF00F6',
                        '#1e90ff',
                        '#2ed573',
                        '#eccc68',
                        '#ff5200',
                        '#cd84f1',
                        '#7efff5',
                        '#7158e2',
                        '#fff200',
                        '#ff9ff3',
                        '#08ffc8',
                        '#3742fa',
                        '#1089ff',
                        '#70FF61',
                        '#bf9fee',
                        '#574b90'
                    ],
                    borderColor: [
                        'rgba(231, 80, 90, 0.75)'
                    ],
                    borderWidth: 0,

                }]
            },
            options: {
                aspectRatio: 1,
                responsive: true,
                elements: {
                    line: {
                        tension: 0 // disables bezier curves
                    }
                },
                scales: {
                    xAxes: [{
                        display: false
                    }],
                    yAxes: [{
                        display: false
                    }]
                },
                legend: {
                    display: false,
                }
            }
        });
    </script>
@endpush
