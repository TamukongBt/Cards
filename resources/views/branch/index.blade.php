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
                    <h4 class="card-title">Branches</h4>
                    <div class="text-right" style='float:right;'>
                        <!-- Button trigger modal -->
                        <a href=# class="btn  btn-primary" type="button" data-toggle="modal" data-target="#modelId">Add A Branch</a>
                    </div>
                    <div class="card-body">
                    </div>
                    <div class="table-responsive">
                        <table id="tables1" class="table ">
                            <thead>

                                <th>
                                  Branch
                                </th>
                                <th>
                                   Branch Code
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



    <!-- Modal -->
    <div class="modal fade" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Add New Branch') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                    <form class="col-md-12" action="{{ route('branch.store') }}" method="POST">
                        @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-row">
                                        <div class="col">
                                            <label class=" col-form-label">{{ __('Branch Name') }}</label>
                                            <input type="text" name="name" class="form-control"
                                                placeholder="Branch Name" required>
                                        </div>
                                        <div class="col">
                                            <label class=" col-form-label">{{ __('Branch Code') }}</label>
                                            <input type="text" name="branch_code" class="form-control"
                                                placeholder="Branch Code" required>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary btn-round" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-info btn-round">{{ __('Create Branch') }}</button>
                            </div>
                    </form>
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
        $('#tables1').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "/branch_ajax",


            "columns": [
                { "data": "name", name: 'Branch Name' },
                { "data": "branch_code", name: ' Branch Code' },
                {
                    data: 'action', name: 'action', orderable: true, searchable: true
                },


            ]

        });
    });



    //Start Edit Record

    $('#tables1').on('click', '.btn-delete[data-remote]', function (e) {
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
            $('#tables1').DataTable().draw(false);
        });
    }else
        alert("You have cancelled!");
});


</script>
@endpush
@endsection
