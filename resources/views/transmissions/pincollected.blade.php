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
                    <h4 class="card-title"> Cards with pins Collected</h4>
                    <div class="text-right" style='float:right;'>
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
                                </th>
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
                                   Collected By
                                </th>
                                <th>
                                    Collected On
                                </th>
                            </thead>
                        </table>
                    </div>
                </div>
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
            "ajax": "/ajax_collectedpin",


            "columns": [
                { "data": "cardholder", name: 'Card Holder' },
                { "data": "card_type", name: 'Type Of Card' },
                { "data": "branchcode", name: 'Branch' },
                { "data": "card_number", name: 'Cards Number' },
                { "data": "phone_number", name: 'Phone Number' },
                { "data": "remarks", name: 'Remarks' },
                { "data": "collected_by", name: 'Collected By' },
                { "data": "collected_at", name: 'Collected On', orderable: true, searchable: true },


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
