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
                @php
                    $id=0;
                @endphp
                <div class="card-header">

                    <div class="text-right" style='float:right;'>
                    </div>
                    <div class="card-body">
                        <h4 class="card-title">Accounts In This Batch</h4>
                    </div>
                    <div class="table-responsive">
                        <table id="table1" class="table ">
                            <thead>

                                <th>
                                    Account Name
                                </th>
                                <th>
                                    Account Number
                                </th>
                                <th>
                                    Card Type
                                </th>
                                <th>
                                    Date Requested
                                </th>


                            </thead>
                            <tbody>
                                @foreach ($accounts as $item)
                                <tr>
                                    <td>{{ $item->account_name }}</td>
                                    <td>{{ $item->account_number }}</td>
                                    <td>{{ $item->cardtype->name }}</td>
                                    <td>{{ $item->created_at->format('Y/m/d') }}</td>
                                  </tr>
                                  @endforeach
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




@push('scripts')

{{-- <script type="text/javascript">

    // This script is used in passing data from the table directly to form in the book hall page
    // var table = $('#myTable').DataTable();
    $(document).ready(function () {
        $('#table1').DataTable({
            "processing": true,
            "serverSide": false,
            "searchable": true,
            "ajax": "/view_ajax",


            "columns": [
                { "data": "account_number", name: 'Account Number', orderable: true, searchable: true },
                { "data": "account_name", name: 'Account Name', orderable: true, searchable: true },
                { "data": "cards", name: 'Cards Requested', orderable: true, searchable: true },
                { "data": "created_at", name: 'Requested Date', orderable: true, searchable: true },
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



</script> --}}
@endpush
@endsection
