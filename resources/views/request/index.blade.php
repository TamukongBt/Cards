@extends('layouts.app', [
'class' => '',
'elementActive' => 'tables'
])

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    @hasanyrole('cards|css|csa')
                    <h4 class="card-title"> Pending @role('css') Unapproved @endrole Request Tables </h4>
                    @endhasanyrole
                    @role('dso') <h4 class="card-title"> Card Renewal Request </h4> @endrole
                    @hasanyrole('cards|css|csa')
                    <div class="text-right" style='float:right;'>
                        <a href="request/create" class="btn  btn-primary" style="background-color: #15224c">New Request</a>
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary " data-toggle="modal" data-target="#modelId" style="background-color: #15224c">
                            Download the data
                        </button>
                    </div>
                    @endhasanyrole
                    <div class="card-body">
                    </div>
                    <div class="table-responsive">
                        <table id="table1" class="table ">
                            <thead>

                                <th>
                                    Account Number
                                </th>
                                <th>
                                    Account Name
                                </th>
                                <th>
                                    Request Type
                                </th>
                                <th>
                                    Card Type
                                </th>
                                <th>
                                    Date Requested
                                </th>
                                <th>
                                    Requested By
                                </th>
                                <th>
                                    Branch
                                </th>
                                @role('it')
                                <th>
                                    Status
                                </th>
                                @else
                                <th>
                                    Actions
                                </th>
                                @endrole

                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- Modal for data download -->
<div class="modal fade" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Choose The date Range for Downloads</h5>

            </div>
        <form action="{{route('export')}}" method="post">
            @csrf
            <div class="modal-body">
                <div class="row">
                    <label class="col-md-3 col-form-label">{{ __('Start Date') }}</label>
                    <div class="col-md-9">
                        <div class="form-group">
                            <input type="date" name="start_date" class="form-control" placeholder="Start Date"  required>
                        </div>
                        @if ($errors->has('start_date'))
                            <span class="invalid-feedback" style="display: block;" role="alert">
                                <strong>{{ $errors->first('start_date') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="row">
                    <label class="col-md-3 col-form-label">{{ __('End Date') }}</label>
                    <div class="col-md-9">
                        <div class="form-group">
                            <input type="date" name="end_date" class="form-control" placeholder="End Date"  required>
                        </div>
                        @if ($errors->has('end_date'))
                            <span class="invalid-feedback" style="display: block;" role="alert">
                                <strong>{{ $errors->first('end_date') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button id="download" type="submit" class="btn btn-primary">Download</button>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal to get reason for rejecting -->
<div class="modal fade" id="modelreject" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header text-light" style="background-color: #15224c; hover:background-color: gold;">
                <h5 class="modal-title">{{ __('Reason') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span  class="text-light " aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                <form class="col-md-12" action="{{ route('request.store') }}" method="POST" id="denied">
                      @csrf
                        <div class="col">
                            <label class=" col-form-label">{{ __('Reason For Rejection') }}</label>
                            <textarea class="form-control" name="reason" cols="40" rows="10" required placeholder="  You must give a reason to proceed"></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" style="background-color: #15224c; hover:background-color: gold;" class="btn btn-secondary btn-round" data-dismiss="modal">Close</button>
                            <button id="send" type="button" style="background-color: #15224c; hover:background-color: gold;" class="btn btn-info btn-round">{{ __('Reject') }}</button>
                        </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')

<script type="text/javascript">

    // This script is used in passing data from the table directly to form in the book hall page
    // var table = $('#myTable').DataTable();
    $(document).ready(function () {
        $('#table1').DataTable({
            "processing": true,
            "serverSide": false,
            "searchable": true,
            "responsive": true,
            "ajax": "/ajax",


            "columns": [
                { "data": "account_number", name: 'Account Number' },
                { "data": "accountname", name: 'Account Name' },
                { "data": "request_type", name: 'Request Type' },
                { "data": "cards", name: 'Cards Requested' },
                { "data": "created_at", name: 'Requested Date' },
                { "data": "requested_by", name: 'Requested By' },
                { "data": "branch_id", name: 'Branch' },

                {
                    data: 'action', name: 'action', orderable: true, searchable: true
                },


            ]

        });
    });

    //Start Edit Record

    $('#table1').on('click', '.btn-delete[data-remote]', function (e) {
    e.preventDefault();
     $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var url = $(this).data('remote');

    // confirm then

    if (confirm('Are you sure you want to delete this?')) {
        $.ajax({
            url: url,
            type: 'DELETE',
            dataType: 'json',
            data:{'_method':'DELETE'},
        }).always(function (data) {
            // $('#table1').DataTable().draw(false);
            $('#table1').DataTable().ajax.reload();
        });
    }else
        alert("You have cancelled!");
});




$('#table1').on('click', '.validates[data-remote]', function (e) {
    e.preventDefault();
     $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var url = $(this).data('remote');

        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            data:{'_method':'GET'},
        }).always(function (data) {
            // $('#table1').DataTable().draw(false);
            $('#table1').DataTable().ajax.reload();
        });

});

$('#table1').on('click', '.denies[data-remote]', function (e) {
    e.preventDefault();
     $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var url = $(this).data('remote');
    var form = $('#denied');
    var send = $('#send');
    //;

    send.click(function (e){
        //ze());

        $.ajax({
            url: url,
            type:"POST",
            dataType: 'json',
            data:form.serialize(),
            success: function (data) {
                $('#modelreject').modal('hide');
            },
            error: function (data) {
                console.log('An error occurred.');
                console.log(data);
            },
        }).always(function (data) {
            // $('#table1').DataTable().draw(false);
            $('#table1').DataTable().ajax.reload();
        });
    });



});



</script>
@endpush
@endsection
