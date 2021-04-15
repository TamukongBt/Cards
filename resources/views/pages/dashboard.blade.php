@extends('layouts.app', [
'class' => '',
'elementActive' => 'dashboard'
])

@section('title')
Dashboard
@endsection

@section('content')
    @auth
        <div class="content">
            @role('cards')
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <a class="text-muted" href="/checkrequest">
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
                                                    Cards</span></p>
                                            <p class="card-title" id="new">
                                            <p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer ">
                                <hr>
                                <div class="stats">
                                    <i class="fa fa-refresh"></i> <a class="text-muted" href="/cardrequest">Update Now</a>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <a class="text-muted" href="/checkrequest">
                            <div class="card-body ">
                                <div class="row">
                                    <div class="col-5 col-md-4">
                                        <div class="icon-big text-center icon-warning">
                                            <i class="nc-icon nc-bullet-list-67  text-success"></i>
                                        </div>
                                    </div>
                                    <div class="col-7 col-md-8">
                                        <div class="numbers">
                                            <p class="card-category">Pending Request<span class="text-mute badge"> For New
                                                    Checks</span>
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
                                    <i class="fa fa-calendar-o"></i><a class="text-muted" href="/checkrequest">Update Now</a>
                                </div>
                            </div>
                        </a>
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
                                        <p class="card-category">Rejected Requests<span class="text-mute badge">Cards & Checks
                                            </span></p>
                                        <p class="card-title" id="slots">
                                        <p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer ">
                            <hr>
                            <div class="stats">
                                <i class="fa fa-clock-o"></i> <a class="text-muted" href="/checkrequest">View Now</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6">

                    <div class="card  card-stats">


                        <!-- Modal -->
                        <div class="modal fade" id="modelId" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Track An account </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group form-group-sm">
                                            <select name="type" id="type" class="form-control " autofocus
                                                placeholder="Choose Request Type">
                                                <option selected="true" disabled="disabled">Select Request Type Type</option>
                                                <option class="text-sm" value="card">Track a Card Request</option>
                                                <option class="text-sm" value="check">Track a Check Request</option>
                                            </select>
                                        </div>

                                        <div class="form-group" id="cardform">
                                            <select name="start" id="start" style="width:100%;"
                                                class="livesearch form-control @error('start_acct') is-invalid @enderror"
                                                required autofocus>
                                            </select>
                                        </div>

                                        <div class="form-group" id="checkform">
                                            <select name="start" id="start2" style="width:100%;"
                                                class="livesearch2 form-control @error('start_acct') is-invalid @enderror"
                                                required autofocus>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-warning" data-dismiss="modal"
                                            style="background-color: #15224c">Close</button>
                                        <button type="button" class="btn btn-warning track" style="background-color: #15224c"
                                            id="track">Track</button>
                                        <button type="button" class="btn btn-warning track2" style="background-color: #15224c"
                                            id="track2">Track</button>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div data-toggle="modal" data-target="#modelId" class="card-body ">
                            <div class="row">
                                <div class="col-5 col-md-4">
                                    <div class="icon-big text-center icon-warning">
                                        <i data-toggle="modal" data-target="#modelId" class="nc-icon nc-box text-primary"></i>
                                    </div>
                                </div>
                                <div class="col-7 col-md-8">
                                    <div class="numbers">
                                        <p class="card-category "> Track A Request <span class="text-mute badge">Track
                                                Progress</span></p>
                                        <p class="card-title" id="batch">
                                        <p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-9">


                        </div>
                        <div class="card-footer ">
                            <hr>
                            <a data-toggle="modal" data-target="#modelId">
                                <div class="stats">
                                    <i class="fa fa-refresh"></i> Track Now
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            @endrole
            @hasanyrole('csa|branchadmin')
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
                                        <p class="card-category">Pending Card Request <span class="text-mute badge"> Made in
                                                {{ auth()->user()->branch->name }}</span></p>
                                        <p class="card-title" id="new">
                                        <p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer ">
                            <hr>
                            <div class="stats">
                                <i class="fa fa-refresh"></i> <a class="text-muted" href="/cardrequest">View Now</a>
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
                                        <p class="card-category">Pending Check Request<span class="text-mute badge"> Made in
                                            {{ auth()->user()->branch->name }}</span>
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
                                <i class="fa fa-calendar-o"></i><a class="text-muted" href="/checkrequest">View All Now</a>
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
                                        <p class="card-category">All Rejected Requests<span class="text-mute badge">for
                                                {{ auth()->user()->branch->name }}</span></p>
                                        <p class="card-title" id="slots">
                                        <p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer ">
                            <hr>
                            <div class="stats">
                                <i class="fa fa-clock-o"></i> <span class="text-muted">This Month</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">

                    <div class="card  card-stats">


                        <!-- Modal -->
                        <div class="modal fade" id="modelId" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Track An account </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group form-group-sm">
                                            <select name="type" id="type" class="form-control " autofocus
                                                placeholder="Choose Request Type">
                                                <option selected="true" disabled="disabled">Select Request Type Type</option>
                                                <option class="text-sm" value="card">Track a Card Request</option>
                                                <option class="text-sm" value="check">Track a Check Request</option>
                                            </select>
                                        </div>

                                        <div class="form-group" id="cardform">
                                            <select name="start" id="start" style="width:100%;"
                                                class="livesearch form-control @error('start_acct') is-invalid @enderror"
                                                required autofocus>
                                            </select>
                                        </div>

                                        <div class="form-group" id="checkform">
                                            <select name="start" id="start2" style="width:100%;"
                                                class="livesearch2 form-control @error('start_acct') is-invalid @enderror"
                                                required autofocus>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-warning" data-dismiss="modal"
                                            style="background-color: #15224c">Close</button>
                                        <button type="button" class="btn btn-warning track" style="background-color: #15224c"
                                            id="track">Track</button>
                                        <button type="button" class="btn btn-warning track2" style="background-color: #15224c"
                                            id="track2">Track</button>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div data-toggle="modal" data-target="#modelId" class="card-body ">
                            <div class="row">
                                <div class="col-5 col-md-4">
                                    <div class="icon-big text-center icon-warning">
                                        <i data-toggle="modal" data-target="#modelId" class="nc-icon nc-box text-primary"></i>
                                    </div>
                                </div>
                                <div class="col-7 col-md-8">
                                    <div class="numbers">
                                        <p class="card-category "> Track A Request <span class="text-mute badge">Track
                                                Progress</span></p>
                                        <p class="card-title" id="batch">
                                        <p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-9">


                        </div>
                        <div class="card-footer ">
                            <hr>
                            <a data-toggle="modal" data-target="#modelId">
                                <div class="stats">
                                    <i class="fa fa-refresh"></i> Track Now
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endhasanyrole





            <div class="row">
                <div class="col-md">
                    <div class="card">
                        <div class="card-header ">
                            <h5 class="title">Cards Request </h5>
                            <p class="card-category">Monthly Statistics</p>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md">
                                    <h1 class="title" id="ca"></h1>
                                    <p class="legend"> <i class="fa fa-circle text-primary"></i>Approved</p>
                                </div>
                                <div class="col-md">
                                    <h1 class="title" id="cp"></h1>
                                    <p class="legend"><i class="fa fa-circle text-danger"></i> In Production</p>
                                </div>
                                <div class="col-md">
                                    <h1 class="title" id="cd"></h1>
                                    <p class="legend"> <i class="fa fa-circle text-success"></i> Distributed</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md">
                    <div class="card">
                        <div class="card-header ">
                            <h5 class="title">Check Request </h5>
                            <p class="card-category">Monthly Statistics</p>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md">
                                    <h1 class="title" id="cha"></h1>
                                    <p class="legend"> <i class="fa fa-circle text-primary"></i>Approved</p>
                                </div>
                                <div class="col-md">
                                    <h1 class="title" id="chp"></h1>
                                    <p class="legend"><i class="fa fa-circle text-danger"></i> In Production</p>
                                </div>
                                <div class="col-md">
                                    <h1 class="title" id="chd"></h1>
                                    <p class="legend"> <i class="fa fa-circle text-success"></i> Distrubuted</p>
                                </div>
                            </div>
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
                                <h1 class="@if (Auth::guest()) text-white @endif">{{ __('Welcome to CARDS n CHECKS.') }}</h1>

                                <p class="@if (Auth::guest()) text-white @endif
                                    text-lead mt-3 mb-0">
                                    {{ __('Are You a user?') }}<a href="/login"> {{ __('Login') }}</a> or
                                    {{ __('Sign Up Here to begin using the system') }} <a href="/register">
                                        {{ __('Register') }}</a>
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
                    $("#checkform").hide();
                    $("#cardform").hide();

                });

            </script>
        @endpush
    @endguest
@endsection


@push('scripts')
    <script>
        $("#type").change(function() {


            var form = "#" + $("#type").val() + "form";
            $("#checkform").hide();
            $("#cardform").hide();
            $(form).show();
            if (form == '#cardform') {
                $(".track").show();
                $(".track2").hide();
            } else {
                $(".track2").show();
                $(".track").hide();
            }

        });
        $('.livesearch').select2({
            placeholder: 'Find Account Number Of Card ',
            ajax: {
                url: '/autosearch',
                dataType: 'json',
                delay: 250,
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: item.account_number + ' , ' + item.accountname + ' , ' + item
                                    .requested_by + ' , ' + item.date,
                                id: item.id
                            }
                        })
                    };
                },
                cache: true
            }
        });

        $('#track').on('click', function(e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var form = $('#start');
            var id = form.val();
            var url = 'card/track/' + id;
            console.log(url);



            $.ajax({
                url: url,
                type: "GET",
                dataType: 'json',
                data: {
                    '_method': 'GET'
                },
                success: function(data) {
                    $('#modelId').modal('hide');
                    Swal.fire(
                        'Request Tracked',
                        data,
                        'success'
                    )
                },
                error: function(data) {
                    console.log(data);
                }
            }).always(function(data) {
                // $('#table1').DataTable().draw(false);
                $('#table1').DataTable().ajax.reload();
            });
        });

        $('.livesearch2').select2({
            placeholder: 'Find Account Number Check',
            ajax: {
                url: '/autosearch2',
                dataType: 'json',
                delay: 250,
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: item.account_number + ' , ' + item.accountname + ' , ' + item
                                    .requested_by + ' , ' + item.date,
                                id: item.id
                            }
                        })
                    };
                },
                cache: true
            }
        });

        $('#track2').on('click', function(e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var form = $('#start2');
            var id = form.val();
            var url = 'check/track/' + id;



            $.ajax({
                url: url,
                type: "GET",
                dataType: 'json',
                data: {
                    '_method': 'GET'
                },
                success: function(data) {
                    $('#modelId').modal('hide');
                    Swal.fire(
                        'Request Tracked',
                        data,
                        'success'
                    )
                },
                error: function(data) {
                    console.log('An error occurred.');
                    console.log(data);
                }
            }).always(function(data) {
                // $('#table1').DataTable().draw(false);
                $('#table1').DataTable().ajax.reload();
            });
        });

    </script>
    <script>
        // Javascript method's body can be found in assets/assets-for-demo/js/demo.js


        $(document).ready(function() {
            $("#checkform").hide();
            $("#cardform").hide();
            $(".track2").hide();
            $(".track").hide();
        });

    </script>

@hasanyrole('cards|dso')

<script>

$(document).ready(function() {
    $.ajax({
            url: '/newca',
            type: "GET",
            dataType: 'json',
            success: function(data) {
                $('#new').append(data);
            },
        });
        $.ajax({
            url: '/newcha',
            type: "GET",
            dataType: 'json',
            success: function(data) {
                $('#pins').append(data);
            },
        });
        $.ajax({
            url: '/rca',
            type: "GET",
            dataType: 'json',
            success: function(data) {
                $('#slots').append(data);
            },
        });
        $.ajax({
            url: '/tcca',
            type: "GET",
            dataType: 'json',
            success: function(data) {
                $('#batch').append(data);
            },
        });


    $.ajax({
        url: '/caa',
        type: "GET",
        dataType: 'json',
        success: function(data) {
            $('#ca').append(data);
        },
    });
    $.ajax({
        url: '/cpa',
        type: "GET",
        dataType: 'json',
        success: function(data) {
            $('#cp').append(data);
        },
    });
    $.ajax({
        url: '/cda',
        type: "GET",
        dataType: 'json',
        success: function(data) {
            $('#cd').append(data);
        },

    });
    $.ajax({
        url: '/cha',
        type: "GET",
        dataType: 'json',
        success: function(data) {
            $('#cha').append(
                data);

        },
    });
    $.ajax({
        url: '/chpa',
        type: "GET",
        dataType: 'json',
        success: function(data) {
            $('#chp').append(
                data);

        },
    });
    $.ajax({
        url: '/chda',
        type: "GET",
        dataType: 'json',
        success: function(data) {
            $('#chd').append(
                data);

        },
    });
});

</script>
@else
<script>

    $(document).ready(function() {

        $.ajax({
            url: '/newc',
            type: "GET",
            dataType: 'json',
            success: function(data) {
                $('#new').append(data);
            },
        });
        $.ajax({
            url: '/newch',
            type: "GET",
            dataType: 'json',
            success: function(data) {
                $('#pins').append(data);
            },
        });
        $.ajax({
            url: '/rc',
            type: "GET",
            dataType: 'json',
            success: function(data) {
                $('#slots').append(data);
            },
        });
        $.ajax({
            url: '/tcc',
            type: "GET",
            dataType: 'json',
            success: function(data) {
                $('#batch').append(data);
            },
        });
        $.ajax({
            url: '/ca',
            type: "GET",
            dataType: 'json',
            success: function(data) {
                $('#ca').append(data);
            },
        });
        $.ajax({
            url: '/cp',
            type: "GET",
            dataType: 'json',
            success: function(data) {
                $('#cp').append(data);
            },
        });
        $.ajax({
            url: '/cd',
            type: "GET",
            dataType: 'json',
            success: function(data) {
                $('#cd').append(data);
            },

        });
        $.ajax({
            url: '/chd',
            type: "GET",
            dataType: 'json',
            success: function(data) {
                $('#chd').append(
                    data);

            },
        });
        $.ajax({
            url: '/chp',
            type: "GET",
            dataType: 'json',
            success: function(data) {
                $('#chp').append(
                    data);

            },
        });
        $.ajax({
            url: '/cha',
            type: "GET",
            dataType: 'json',
            success: function(data) {
                $('#cha').append(
                    data);

            },
        });
    });

    </script>
@endrole

@endpush


