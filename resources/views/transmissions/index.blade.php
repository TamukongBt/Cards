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
                    @hasanyrole('cards|css')
                    <h4 class="card-title"> @role('css')Pending @endrole Transmissions </h4>
                    @endhasanyrole
                    @role('dso') <h4 class="card-title"> Cards Available </h4> @endrole
                    <div class="text-right" style='float:right;'>
                        @role('cards')
                        <a href="transmissions/create" class="btn  btn-primary" style="background-color: #15224c">Upload New Cards</a>
                        @endrole
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary " data-toggle="modal" data-target="#modelId" style="background-color: #15224c">
                            Download the data
                        </button>
                    </div>
                    <div class="card-body">
                    </div>
                    <div class="table-responsive">
                        <table id="table1" class="table ">
                            <thead>

                                <th>
                                    Card Holder
                                </th>
                                <th>
                                    Type Of Card
                                </th>
                                <th>
                                    Branch
                                </th>.
                                <th>
                                   Card Number
                                </th>
                                <th>
                                    Phone Number
                                 </th>
                                <th>
                                    Remarks
                                </th>
                                <th>
                                   Created_On
                                </th>
                                <th>
                                    Action
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
<div class="modal fade" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Choose The date Range for Downloads</h5>

            </div>
        <form action="{{route('export.collected')}}" method="post">
            @csrf
            <div class="modal-body">
                <div class="class="form-group"">
                    <div class="col-md">
                        <input type="file" name="file" class="form-control-file">
                    </div>

                    @if ($errors->has('file'))
                        <span class="invalid-feedback" style="display: block;" role="alert">
                            <strong>{{ $errors->first('file') }}</strong>
                        </span>
                    @endif
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
            <div class="modal-header">
                <h5 class="modal-title">{{ __('Collected By') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                <form class="col-md-12"  method="POST" id="denied">
                    @csrf

                        <div class="card-body">
                            <div class="row">
                                <label class="col-md-3 col-form-label">{{ __('Collected By') }}</label>
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <input type="text" name="collected_by" class="form-control" placeholder="Collected By"  required>
                                    </div>
                                    @if ($errors->has('collected_by'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('collected_by') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" style="background-color: #15224c; hover:background-color: gold;" class="btn btn-secondary btn-round" data-dismiss="modal">Close</button>
                            <button id="send" type="button" style="background-color: #15224c; hover:background-color: gold;" class="btn btn-info btn-round">{{ __('DONE') }}</button>
                        </div>
                </form>
            </div>
        </div>
    </div>
</div>

@role('dso')
@push('scripts')


<script type="text/javascript">

    // This script is used in passing data from the table directly to form in the book hall page
    // var table = $('#myTable').DataTable();
    $(document).ready(function () {
        $('#table1').DataTable({
            "processing": true,
            "serverSide": false,
            "searchable": true,
            "ajax": "/transmissions_ajax",


            "columns": [
                { "data": "cardholder", name: 'Card Holder' },
                { "data": "card_type", name: 'Type Of Card' },
                { "data": "branchcode", name: 'Branch' },
                { "data": "card_number", name: 'Cards Number' },
                { "data": "phone_number", name: 'Phone Number' },
                { "data": "remarks", name: 'Remarks' },
                { "data": "created_at", name: 'Collected On', orderable: true, searchable: true },
                {
                    data: 'age', name: 'age', orderable: true, searchable: true
                },


            ],
            "createdRow": function (row, data, index) {
                const threeMonthsAgo = new Date();
                const sixMonthsAgo = new Date();


                threeMonthsAgo.setMonth(threeMonthsAgo.getMonth() - 3);
                sixMonthsAgo.setMonth(sixMonthsAgo.getMonth() - 6);

                const  created = new Date( data['created_at'] );

                if (  threeMonthsAgo > created  ) {
                    $('td', row).eq(8).addClass('success');
                } else if( sixMonthsAgo > created ){
                    $('td', row).eq(8).addClass('danger');
                }else{
                    $('td', row).eq(2).addClass(' ');
                }
            }


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
            console.log(data);
            // $('#table1').DataTable().draw(true);
            $('#table1').DataTable().ajax.reload();
        });
    }else
        alert("You have cancelled!");
});







</script>
@endpush
@endrole

@hasanyrole('cards|css|csa|it')
@push('scripts')


<script type="text/javascript">

    // This script is used in passing data from the table directly to form in the book hall page
    // var table = $('#myTable').DataTable();
    $(document).ready(function () {
        $('#table1').DataTable({
            "processing": true,
            "serverSide": false,
            "searchable": true,
            "ajax": "/transmissions_ajax",


            "columns": [
                { "data": "cardholder", name: 'Card Holder' },
                { "data": "card_type", name: 'Type Of Card' },
                { "data": "branchcode", name: 'Branch' },
                { "data": "card_number", name: 'Cards Number' },
                { "data": "phone_number", name: 'Phone Number' },
                { "data": "remarks", name: 'Remarks' },
                { "data": "created_at", name: 'Collected On', orderable: true, searchable: true },
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
            console.log(data);
            // $('#table1').DataTable().draw(true);
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
            $('#table1').DataTable().ajax.reload();
            $('#table1').DataTable().draw(false);
        });
    });



});



</script>
@endpush
@endhasanyrole
@endsection
