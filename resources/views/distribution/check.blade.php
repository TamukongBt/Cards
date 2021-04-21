@extends('layouts.app', [
'class' => '',
'elementActive' => 'check'
])

@section('title')
Checkbook Distribution | Pending Collection
@endsection

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Checkbook Distribution <br> <small>Pending Collection</small> </h4>
                    @hasanyrole('cards')
                    <div class="text-right" style='float:right;'>
                        <button type="button" class="btn btn-warning " data-toggle="modal" data-target="#modelId" style="background-color: #15224c">
                            Notify Clients
                        </button>
                    </div>
                    @endhasanyrole
                    <div class="card-body">
                    </div>
                    <div class="table-responsive">
                        <table id="table1" class="table table-bordered">
                            <thead>
                                <th>
                                     Check Holder
                                </th>
                                <th>
                                    Account Number
                                </th>
                                <th>
                                    Type Of Check
                                </th>
                                <th>
                                    Requested By
                                </th>
                                <th>
                                    Telephone
                                </th>
                                <th>
                                </th>


                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- Modal for data download -->
<!-- Modal for data download -->
<div class="modal fade" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Choose The Date Range for Notification</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
        <form action="{{route('check.store')}}" method="post">
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
                <button type="button" class="btn btn-secondary" data-dismiss="modal" style="background-color: #15224c">Close</button>
                <button type="submit" id="download" class="btn btn-primary" style="background-color: #15224c">Notify</button>
            </div>
            </form>
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
            "ajax": "/distribution_ajax",


            "columns": [
                { "data": "accountname", name: 'Account Name', orderable: true, searchable: true },
                { "data": "account_number", name: 'Account Number', orderable: true, searchable: true },
                { "data": "checks", name: 'Checks Requested', orderable: true, searchable: true },
                { "data": "requested_by", name: 'Requested By' , orderable: true, searchable: true},
                { "data": "tel", name: 'Telephone' , orderable: true, searchable: true},
                {
                    data: 'action', name: 'Status', orderable: true, searchable: true
                },
            ]

        });
    });

    // close modal
    $('#download').click(function(){
    $('#modelId').modal('hide');
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
            $('#table1').DataTable().draw(false);
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
            $('#table1').DataTable().draw(false);
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

        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            data:{'_method':'GET'},
        }).always(function (data) {
            $('#table1').DataTable().draw(false);
            $('#table1').DataTable().ajax.reload();
        });

});



</script>
@endpush
@endsection
