@extends('layouts.app', [
'class' => '',
'elementActive' => 'dashboard'
])

@section('content')
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
    @role('css')
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
    @endrole
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

    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header ">
                    <h5 class="card-title">Users Behavior</h5>
                    <p class="card-category">24 Hours performance</p>
                </div>
                <div class="card-body ">
                    <canvas id=chartHours width="400" height="100"></canvas>
                </div>
                <div class="card-footer ">
                    <hr>
                    <div class="stats">
                        <i class="fa fa-history"></i> <a href="/request">Updated 3 minutes ago</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="card ">
                <div class="card-header ">
                    <h5 class="card-title">Email Statistics</h5>
                    <p class="card-category">Last Campaign Performance</p>
                </div>
                <div class="card-body ">
                    <canvas id="chartEmail"></canvas>
                </div>
                <div class="card-footer ">
                    <div class="legend">
                        <i class="fa fa-circle text-primary"></i> Opened
                        <i class="fa fa-circle text-warning"></i> Read
                        <i class="fa fa-circle text-danger"></i> Deleted
                        <i class="fa fa-circle text-gray"></i> Unopened
                    </div>
                    <hr>
                    <div class="stats">
                        <i class="fa fa-calendar"></i> Number of emails sent
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card card-chart">
                <div class="card-header">
                    <h5 class="card-title">NASDAQ: AAPL</h5>
                    <p class="card-category">Line Chart with Points</p>
                </div>
                <div class="card-body">
                    <canvas id="speedChart" width="400" height="100"></canvas>
                </div>
                <div class="card-footer">
                    <div class="chart-legend">
                        <i class="fa fa-circle text-info"></i> Tesla Model S
                        <i class="fa fa-circle text-warning"></i> BMW 5 Series
                    </div>
                    <hr />
                    <div class="card-stats">
                        <i class="fa fa-check"></i> Data information certified
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@role('cards')
@push('scripts')
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">google.load('visualization', '1.0', {'packages':['corechart']});</script>

    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {

        google.visualization.arrayToDataTable([
            ['Day', 'Cards'],
            $.ajax({
                url: '/groupcount',
                type: "GET",
                dataType: 'json',
                success: function (data){
                    var len = data.length;
                   for(var i=0; i<len; i++){
                        var id = response[i].created;
                        var username = response[i].number;


                    }


                    var draw = new google.visualization.DataTable(data);
                    var options = {
                        title: 'Cards Created this Month',
                    };
                    var chart = new  google.visualization.PieChart(document.getElementById('chart_div'));
                        chart.draw(draw, options);



                },



            }) ]);


        }
      </script>
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

@role('css')
@push('scripts')
<script>
    $(document).ready(function () {
        // Javascript method's body can be found in assets/assets-for-demo/js/demo.js
        demo.initChartsPages();
        $(document).ready(function () {
            $.ajax({
                url: '/validatedcount',
                type: "GET",
                dataType: 'json',
                success: function (data) {
                    $('#new').append(data);
                    $.ajax({
                        url: '/rejectedcount',
                        type: "GET",
                        dataType: 'json',
                        success: function (data) {
                            $('#pins').append(data);
                            $.ajax({
                                url: '/pendingcount',
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
