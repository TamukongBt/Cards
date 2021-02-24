@extends('layouts.app', [
'class' => '',
'elementActive' => 'dashboard'
])

@section('content')
@auth
<div class="content">
    @role('cards')
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-5 col-md-4">
                            <div class="icon-big text-center icon-warning">
                                <i class="nc-icon nc-tv-2 text-warning"></i>
                            </div>
                        </div>
                        <div class="col-7 col-md-8">
                            <div class="numbers">
                                <p class="card-category">Pending Request <span class="text-mute badge"> for New
                                        Accounts</span></p>
                                <p class="card-title" id="new">
                                <p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer ">
                    <hr>
                    <div class="stats">
                        <i class="fa fa-refresh"></i> <a class="text-muted" href="/request">Update Now</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-5 col-md-4">
                            <div class="icon-big text-center icon-warning">
                                <i class="nc-icon nc-bullet-list-67  text-success"></i>
                            </div>
                        </div>
                        <div class="col-7 col-md-8">
                            <div class="numbers">
                                <p class="card-category">Other Request<span class="text-mute badge"> for Accounts</span>
                                </p>
                                <p class="card-title" id="pins">
                                <p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer ">
                    <hr>
                    <div class="stats">
                        <i class="fa fa-calendar-o"></i><a class="text-muted" href="/request">Update Now</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-5 col-md-4">
                            <div class="icon-big text-center icon-warning">
                                <i class="nc-icon nc-credit-card text-danger"></i>
                            </div>
                        </div>
                        <div class="col-7 col-md-8">
                            <div class="numbers">
                                <p class="card-category">Slots Available<span class="text-mute badge">for creating
                                        accounts</span></p>
                                <p class="card-title" id="slots">
                                <p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer ">
                    <hr>
                    <div class="stats">
                        <i class="fa fa-clock-o"></i> <a class="text-muted" href="/slots">View Now</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-5 col-md-4">
                            <div class="icon-big text-center icon-warning">
                                <i class="nc-icon nc-box text-primary"></i>
                            </div>
                        </div>
                        <div class="col-7 col-md-8">
                            <div class="numbers">
                                <p class="card-category"> Batch created<span class="text-mute badge">New Cards
                                        Batch</span></p>
                                <p class="card-title" id="batch">
                                <p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer ">
                    <hr>
                    <div class="stats">
                        <i class="fa fa-refresh"></i> 13 Hours Ago
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endrole
    @hasanyrole('csa|css')
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-5 col-md-4">
                            <div class="icon-big text-center icon-warning">
                                <i class="nc-icon nc-tv-2 text-warning"></i>
                            </div>
                        </div>
                        <div class="col-7 col-md-8">
                            <div class="numbers">
                                <p class="card-category">Pending Request <span class="text-mute badge"> Made in
                                        {{auth()->user()->branch->name}}</span></p>
                                <p class="card-title" id="new">
                                <p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer ">
                    <hr>
                    <div class="stats">
                        <i class="fa fa-refresh"></i> <a class="text-muted" href="/request/create">Add New</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-5 col-md-4">
                            <div class="icon-big text-center icon-warning">
                                <i class="nc-icon nc-check-2  text-success"></i>
                            </div>
                        </div>
                        <div class="col-7 col-md-8">
                            <div class="numbers">
                                <p class="card-category">Approved Request<span class="text-mute badge"> for
                                        Accounts</span>
                                </p>
                                <p class="card-title" id="pins">
                                <p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer ">
                    <hr>
                    <div class="stats">
                        <i class="fa fa-calendar-o"></i><a class="text-muted" href="/validated">View All Now</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-5 col-md-4">
                            <div class="icon-big text-center icon-warning">
                                <i class="nc-icon nc-simple-remove text-danger"></i>
                            </div>
                        </div>
                        <div class="col-7 col-md-8">
                            <div class="numbers">
                                <p class="card-category">Rejected Requests<span class="text-mute badge">for
                                        {{auth()->user()->branch->name}}</span></p>
                                <p class="card-title" id="slots">
                                <p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer ">
                    <hr>
                    <div class="stats">
                        <i class="fa fa-clock-o"></i> <a class="text-muted" href="/rejected">View Now</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-5 col-md-4">
                            <div class="icon-big text-center icon-warning">
                                <i class="nc-icon nc-credit-card text-primary"></i>
                            </div>
                        </div>
                        <div class="col-7 col-md-8">
                            <div class="numbers">
                                <p class="card-category"> New Cards Created<span class="text-mute badge">New Cards
                                        Approved</span></p>
                                <p class="card-title" id="batch">
                                <p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer ">
                    <hr>
                    <div class="stats">
                        <i class="fa fa-refresh"></i> 13 Hours Ago
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endhasanyrole
    @role('it')
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-5 col-md-4">
                            <div class="icon-big text-center icon-warning">
                                <i class="nc-icon nc-tv-2 text-warning"></i>
                            </div>
                        </div>
                        <div class="col-7 col-md-8">
                            <div class="numbers">
                                <p class="card-category">Pending Slot Request <span class="text-mute badge"> Made this
                                        month</span></p>
                                <p class="card-title" id="new">
                                <p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer ">
                    <hr>
                    <div class="stats">
                        <i class="fa fa-refresh"></i> <a class="text-muted" href="/slot">Review</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-5 col-md-4">
                            <div class="icon-big text-center icon-warning">
                                <i class="nc-icon nc-check-2  text-success"></i>
                            </div>
                        </div>
                        <div class="col-7 col-md-8">
                            <div class="numbers">
                                <p class="card-category">Approved Request <span class="text-mute badge"> for New Cards
                                        and Checkbook</span>
                                </p>
                                <p class="card-title" id="pins">
                                <p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer ">
                    <hr>
                    <div class="stats">
                        <i class="fa fa-calendar-o"></i><a class="text-muted" href="/validated">View All Now</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-5 col-md-4">
                            <div class="icon-big text-center icon-warning">
                                <i class="nc-icon nc-simple-remove text-danger"></i>
                            </div>
                        </div>
                        <div class="col-7 col-md-8">
                            <div class="numbers">
                                <p class="card-category">Latest Batch deployed<span class="text-mute badge">for this
                                        month</span></p>
                                <p class="card-title" id="slots">
                                <p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer ">
                    <hr>
                    <div class="stats">
                        <i class="fa fa-clock-o"></i> <a class="text-muted" href="/batch">View Now</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
    @endrole

    @role('dso')
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-5 col-md-4">
                            <div class="icon-big text-center icon-warning">
                                <i class="nc-icon nc-tv-2 text-warning"></i>
                            </div>
                        </div>
                        <div class="col-7 col-md-8">
                            <div class="numbers">
                                <p class="card-category">Cards In Stock <span class="text-mute badge"> Total Number </span></p>
                                <p class="card-title" id="new">
                                <p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer ">
                    <hr>
                    <div class="stats">
                        <i class="fa fa-refresh"></i> <a class="text-muted" href="/transmissions">View Now</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-5 col-md-4">
                            <div class="icon-big text-center icon-warning">
                                <i class="nc-icon nc-bullet-list-67  text-success"></i>
                            </div>
                        </div>
                        <div class="col-7 col-md-8">
                            <div class="numbers">
                                <p class="card-category">Over Due Cards<span class="text-mute badge">Over 3 Months Old</span>
                                </p>
                                <p class="card-title" id="pins">
                                <p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer ">
                    <hr>
                    <div class="stats">
                        <i class="fa fa-calendar-o"></i><a class="text-muted" href="/request">View Now</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-5 col-md-4">
                            <div class="icon-big text-center icon-warning">
                                <i class="nc-icon nc-credit-card text-danger"></i>
                            </div>
                        </div>
                        <div class="col-7 col-md-8">
                            <div class="numbers">
                                <p class="card-category">Total Request <span class="text-mute badge">for New Cards </span></p>
                                <p class="card-title" id="slots">
                                <p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer ">
                    <hr>
                    <div class="stats">
                        <i class="fa fa-clock-o"></i> <a class="text-muted" href="/request">View Now</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-5 col-md-4">
                            <div class="icon-big text-center icon-warning">
                                <i class="nc-icon nc-box text-primary"></i>
                            </div>
                        </div>
                        <div class="col-7 col-md-8">
                            <div class="numbers">
                                <p class="card-category"> Card Renewals<span class="text-mute badge">Request made this month </span></p>
                                <p class="card-title" id="batch">
                                <p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer ">
                    <hr>
                    <div class="stats">
                        <i class="fa fa-refresh"></i> 13 Hours Ago
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endrole


    <div class="row">
        <div class="col-md-4">
            <div class="card ">
                <div class="card-header ">
                    <h5 class="card-title">Cards and Cheque Request </h5>
                    <p class="card-category">Monthly Statistics</p>
                </div>
                <div class="card-body ">
                    <canvas id="chartEmail"></canvas>
                </div>
                <div class="card-footer ">
                    <div class="legend">
                        <i class="fa fa-circle text-primary"></i> Approved
                        <i class="fa fa-circle text-danger"></i> Rejected
                        <i class="fa fa-circle text-gray"></i> Pending
                    </div>
                    <hr>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card ">
                <div class="card-header ">
                    <h5 class="card-title">Cards Transmissions</h5>
                        <p class="card-category">Monthly Statistics</p>
                </div>
                <div class="card-body ">
                    <canvas id="chartCards"></canvas>
                </div>
                <div class="card-footer ">
                    <div class="legend">
                        <i class="fa fa-circle text-primary"></i> Collected
                        <i class="fa fa-circle text-gray"></i> Pending
                    </div>
                    <hr>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card ">
                <div class="card-header ">
                    <h5 class="card-title">Cheque Transmissions</h5>
                        <p class="card-category">Monthly Statistics</p>
                </div>
                <div class="card-body ">
                    <canvas id="chartCheques"></canvas>
                </div>
                <div class="card-footer ">
                    <div class="legend">
                        <i class="fa fa-circle text-primary"></i> Collected
                        <i class="fa fa-circle text-gray"></i> Pending
                    </div>
                    <hr>
                </div>
            </div>
        </div>

    </div>
</div>
@endauth
@guest
<div class="content col-md-12 ml-auto mr-auto">
    <div class="header py-5 pb-7 pt-lg-9">
        <div class="container col-md-10">
            <div class="header-body text-center mb-7">
                <div class="row justify-content-center">
                    <div class="col-lg-8 col-md-12 pt-5">
                        <h1 class="@if(Auth::guest()) text-white @endif">{{ __('Welcome to CARDS n CHECKS.') }}</h1>

                        <p class="@if(Auth::guest()) text-white @endif text-lead mt-3 mb-0">
                            {{ __('Are You a user?') }}<a href="/login"> {{ __('Login') }}</a> or {{ __('Sign Up Here to begin using the system') }} <a href="/register"> {{ __('Register') }}</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
    $(document).ready(function() {
        demo.checkFullPageBackgroundImage();
    });
</script>
@endpush
@endguest
@endsection

@role('cards')
@push('scripts')

<script>
    $(document).ready(function () {
        // Javascript method's body can be found in assets/assets-for-demo/js/demo.js
        demo.initChartsPages();
        $(document).ready(function () {
            $.ajax({
                url: '/week',
                type: "GET",
                dataType: 'json',
                success: function (data) {
                    $('#new').append(data);
                    $.ajax({
                        url: '/other_ajax',
                        type: "GET",
                        dataType: 'json',
                        success: function (data) {
                            $('#pins').append(data);
                            $.ajax({
                                url: '/slotso',
                                type: "GET",
                                dataType: 'json',
                                success: function (data) {
                                    $('#slots').append(data);
                                    $.ajax({
                                        url: '/batch1',
                                        type: "GET",
                                        dataType: 'json',
                                        success: function (data) {
                                            $('#batch').append(data);

                                        },
                                    });
                                },
                                error: function (data) {
                                    console.log(data);
                                    $('#slots').append(0);
                                    $.ajax({
                                        url: '/batch1',
                                        type: "GET",
                                        dataType: 'json',
                                        success: function (data) {
                                            $('#batch').append(data);
                                        },
                                        error: function (data) {
                                        console.log(data);
                                        $('#batch').append(0);
                                        $.ajax({
                                            url: '/batch1',
                                            type: "GET",
                                            dataType: 'json',
                                            success: function (data) {
                                                $('#batch').append(data);
                                            },
                                    });
                                },
                                    });
                                },
                            });
                        },
                    });
                },

            });

        });
    });
</script>
@endpush
@endrole

@role('dso')
@push('scripts')

<script>
    $(document).ready(function () {
        // Javascript method's body can be found in assets/assets-for-demo/js/demo.js
        demo.initChartsPages();
        $(document).ready(function () {
            $.ajax({
                url: '/stock',
                type: "GET",
                dataType: 'json',
                success: function (data) {
                    $('#new').append(data);
                    $.ajax({
                        url: '/overdue',
                        type: "GET",
                        dataType: 'json',
                        success: function (data) {
                            $('#pins').append(data);
                            $.ajax({
                                url: '/week',
                                type: "GET",
                                dataType: 'json',
                                success: function (data) {
                                    $('#slots').append(data);
                                    $.ajax({
                                        url: '/renew',
                                        type: "GET",
                                        dataType: 'json',
                                        success: function (data) {
                                            $('#batch').append(data);

                                        },
                                    });
                                },
                                error: function (data) {
                                    console.log(data);
                                    $('#slots').append(0);
                                    $.ajax({
                                        url: '/batch1',
                                        type: "GET",
                                        dataType: 'json',
                                        success: function (data) {
                                            $('#batch').append(data);
                                        },
                                        error: function (data) {
                                        console.log(data);
                                        $('#batch').append(0);
                                        $.ajax({
                                            url: '/week',
                                            type: "GET",
                                            dataType: 'json',
                                            success: function (data) {
                                                $('#batch').append(data);
                                            },
                                    });
                                },
                                    });
                                },
                            });
                        },
                    });
                },

            });

        });
    });
</script>
@endpush
@endrole

@hasanyrole('csa|css')
@push('scripts')
<script>

        $(document).ready(function () {
            $.ajax({
                url: '/pendingcount',
                type: "GET",
                dataType: 'json',
                success: function (data) {
                    $('#new').append(data);
                    $.ajax({
                        url: '/validatedcount',
                        type: "GET",
                        dataType: 'json',
                        success: function (data) {
                            $('#pins').append(data);
                            $.ajax({
                                url: '/rejectedcount',
                                type: "GET",
                                dataType: 'json',
                                success: function (data) {
                                    $('#slots').append(data);
                                    $.ajax({
                                        url: '/newcardbranch',
                                        type: "GET",
                                        dataType: 'json',
                                        success: function (data) {
                                            $('#batch').append(data);

                                        },
                                    });
                                },
                                error: function (data) {
                                    $('#slots').append(0);
                                }
                            });
                        },
                    });
                },
            });




        });

</script>
@endpush
@endhasanyrole

@role('it')
@push('scripts')
<script>
    $(document).ready(function () {
        // Javascript method's body can be found in assets/assets-for-demo/js/demo.js
        demo.initChartsPages();
        $(document).ready(function () {
            $.ajax({
                url: '/slotsed',
                type: "GET",
                dataType: 'json',
                success: function (data) {
                    $('#new').append(data);
                    $.ajax({
                        url: '/validatedcountit',
                        type: "GET",
                        dataType: 'json',
                        success: function (data) {
                            $('#pins').append(data);
                            $.ajax({
                                url: '/batchno',
                                type: "GET",
                                dataType: 'json',
                                success: function (data) {
                                    $('#slots').append(data);
                                    $.ajax({
                                        url: '/batch1',
                                        type: "GET",
                                        dataType: 'json',
                                        success: function (data) {
                                            $('#batch').append(data);

                                        },
                                    });
                                },
                            });
                        },
                    });
                },

            });

        });
    });
</script>
@endpush
@endrole
