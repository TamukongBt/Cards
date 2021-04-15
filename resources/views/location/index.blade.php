@extends('layouts.app', [
'class' => '',
'elementActive' => 'tables'
])

@section('title')
Transfer Change Request
@endsection


@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">


                    <div class="card-body">
                    </div>
                    <div class="table-responsive">
                        <table id="t" class="table">
                            <thead>
                                <th>
                                   Employee Name
                                </th>
                                <th>
                                   Employee ID
                                </th>
                                <th>
                                    Old Branch
                                </th>
                                <th>
                                  New Branch
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
        $('#t').DataTable({
            "processing": true,
            "serverSide": false,
            "searchable": true,
            "responsive": true,
            "ajax": "/changes",


            "columns": [
                { "data": "name",},
                { "data": "employee_id", },
                { "data": "oldbranch", },
                { "data": "newbranch",},
                {
                    data: 'action', name: 'action', orderable: true, searchable: true
                },



            ]

        });
    });






$('#t').on('click', '.validates[data-remote]', function (e) {
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
                        'The Branch has been changed',
                        'success'
                    ),
                    $('#t').DataTable().ajax.reload();

        });

});





</script>
@endpush
@endsection
