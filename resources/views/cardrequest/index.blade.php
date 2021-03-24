@extends ('layouts.app', [
    'class' => '',
    'elementActive' => 'tables'
])
@section('title')
@role('branchadmin') Unapproved @endrole    Card Request
@endsection

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                        @hasanyrole('cards|css|csa')
                    <h4 class="card-title"> @role('branchadmin') Unapproved @endrole Card Reqeusts </h4>
                    @endhasanyrole
                    @role('dso') <h4 class="card-title"> Card Renewal Request </h4> @endrole
                    @hasanyrole('cards|css|csa')
                    <div class="text-right" style='float:right;'>
                        <a href="cardrequest/create" class="btn  btn-primary" style="background-color: #15224c">New Request</a>
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
{{--
                                <th>
                                    Card Number
                                </th> --}}
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



<!--Modal for data download-- >
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
                                    <input type="date" name="start_date" class="form-control" placeholder="Start Date" required>
                        </div>
                        @if ($errors->has('start_date'))
                            <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors-> first('start_date')}}</strong>
                                    </span>
                        @endif
                    </div>
                            </div>

                            <div class="row">
                                <label class="col-md-3 col-form-label">{{ __('End Date') }}</label>
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <input type="date" name="end_date" class="form-control" placeholder="End Date" required>
                        </div>
                        @if ($errors->has('end_date'))
                            <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors-> first('end_date')}}</strong>
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
                                <span class="text-light " aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form class="col-md-12" action="{{ route('cardrequest.store') }}" method="POST" id="denied">
                                @csrf
                        <div class="col">
                                    <label class=" col-form-label">{{ __('Reason For Rejection') }}</label>
                                    <select name="reason"  class="form-control @error('request_type') is-invalid @enderror"  >
                                        <option selected="true" disabled="disabled">Choose Your Reason of Rejection</option>
                                        <option value="1">OPtion 1</option>
                                        <option value="2">Option 2</option>
                                        <option value="3">Option 3</option>
                                    </select>
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

                            // { "data": undefined, "defaultContent": '<input type="text" value="0" size="10"/>'},
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

    swal.fire({
                    title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel!',
        reverseButtons: true
        }).then((result) => {
        if (result.isConfirmed) {
                    {
                        $.ajax({
                            url: url,
                            type: 'DELETE',
                            dataType: 'json',
                            data: { '_method': 'DELETE' },
                        }).always(function (data) {
                            // $('#table1').DataTable().draw(false);
                            $('#table1').DataTable().ajax.reload();
                        });
                    }
            Swal.fire(
            'Deleted!',
            'Your file has been deleted.',
            'success'
            )
        }
        else if (
    /* Read more about handling dismissals below */
    result.dismiss === Swal.DismissReason.cancel
  ) {
                    swal.fire(
                        'Cancelled',
                        'The Operation was Cancelled',
                        'error'
                    )
                }

}) ; })

</script>
@role('cards')
<script>


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

                    Swal.fire(
                        'Approved!',
                        'The request has been completed',
                        'success'
                    ),
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
    console.log(url);

    send.click(function (e){
        console.log(form.serialize());

        $.ajax({
            url: url,
            type:"POST",
            dataType: 'json',
            data:form.serialize(),
            beforeSend:function()
                {
                    Swal.showLoading ();
                    Swal.fire({



                    })
                },

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
@else
<script>


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

                        Swal.fire(
                            'Confirmed!',
                            'The request has been fowarded to the Cards & Checks Office',
                            'success'
                        ),
                        $('#table1').DataTable().ajax.reload();

            });

    });
    </script>
@endrole
<script>

$('#table1').on('click', '.track[data-remote]', function (e) {
                    e.preventDefault();
     $.ajaxSetup({
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var url = $(this).data('remote');

    console.log(url);

        $.ajax({
            url: url,
            type:"GET",
            dataType: 'json',
            data:{'_method':'GET'},
            success: function (data) {
                Swal.fire(
                        'Request Tracked',
                        data,
                        'success'
                    )
            },
            error: function (data) {
                    console.log('An error occurred.');
                console.log(data);
            }
        }).always(function (data) {
                    // $('#table1').DataTable().draw(false);
                    $('#table1').DataTable().ajax.reload();
        });




});



</script>
@endpush
@endsection
