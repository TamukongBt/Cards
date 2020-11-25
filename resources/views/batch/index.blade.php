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
                    <h4 class="card-title">Batch Created</h4>
                    <div class="text-right" style='float:right;'>
                        <a href="batch/create" class="btn  btn-primary" style="background-color: #15224c">Register New Batch Created</a>
                        <!-- Button trigger modal -->
                    </div>
                    <div class="card-body">
                    </div>
                    <div class="table-responsive">
                        <table id="tables" class="table ">
                            <thead>

                                <th>
                                   Batch Number
                                </th>
                                <th>
                                    First Account In Batch
                                </th>
                                <th>
                                    Last Account In Batch
                                </th>
                                <th>
                                   Slot Details
                                </th>
                                <th>
                                    Date Created
                                </th>
                                <th>
                                    Actions
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
        $('#tables').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "/batch_ajax",


            "columns": [
                { "data": "batch_number", name: 'Batch Number' },
                { "data": "start_acct", name: 'First Account In Batch' },
                { "data": "end_acct", name: ' Last Account In Batch' },
                { "data": "description", name: 'Slot Details' },
                { "data": "created_at", name: ' Date Created' },
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
            $('#table1').DataTable().draw(false);
        });
    }else
        alert("You have cancelled!");
});




</script>
@endpush
@endsection
