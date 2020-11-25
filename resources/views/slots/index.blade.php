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
                    <h4 class="card-title">Slots Requested</h4>
                    <div class="text-right" style='float:right;'>
                        <!-- Button trigger modal -->
                        <a href=# class="btn  btn-primary" type="button" data-toggle="modal" data-target="#modelId" style="background-color: #15224c; hover:background-color: gold;">Request Extra Slots</a>
                    </div>
                    <div class="card-body">
                    </div>
                    <div class="table-responsive">
                        <table id="tables" class="table ">
                            <thead>

                                <th>
                                  Slot Request
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



    <!-- Modal -->
    <div class="modal fade" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('New Slots Request') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                    <form class="col-md-12" action="{{ route('slots.store') }}" method="POST">
                        @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-row">
                                        <div class="col">
                                            <label class=" col-form-label"><span style="color: goldenrod; font-size: 15px; padding-right: .5rem; "> <i class="fa fa-circle" aria-hidden="true"></i></span>{{ __('Gold Cards') }}</label>
                                            <input type="text" name="gold" class="form-control"
                                                placeholder="Gold Slots" required>
                                        </div>
                                        <div class="col">
                                            <label class=" col-form-label"><span style="color: silver; font-size: 15px; padding-right: .5rem; "> <i class="fa fa-circle" aria-hidden="true"></i></span>{{ __('Silver Cards') }}</label>
                                            <input type="text" name="silver" class="form-control"
                                                placeholder="Silver Slots" required>
                                        </div>
                                        <div class="col">
                                            <label class=" col-form-label"><span style="color: #0f52ba; font-size: 15px; padding-right: .5rem; "> <i class="fa fa-circle" aria-hidden="true"></i></span>{{ __('Sapphire Cards') }}</label>
                                            <input type="text" name="sapphire" class="form-control"
                                                placeholder="Sapphire Slots" required>
                                        </div>
                                    </div>
                                </div>
                                <input name="done_by" id="done_by" value='{{ auth()->user()->employee_id }}' required hidden>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary btn-round" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-info btn-round">{{ __('Make Request') }}</button>
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
        $('#tables').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "/slots_ajax",


            "columns": [
                { "data": "description", name: 'Slot Details' },
                { "data": "created_at", name: ' Date Created' },
                {
                    data: 'action', name: 'action', orderable: true, searchable: true
                },


            ]

        });
    });



    //Start Edit Record

    $('#tables').on('click', '.btn-delete[data-remote]', function (e) {
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
            $('#tables').DataTable().draw(false);
        });
    }else
        alert("You have cancelled!");
});


$('#tables').on('click', '.validates[data-remote]', function (e) {
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
            $('#tables').DataTable().draw(false);
        });

});

$('#tables').on('click', '.denies[data-remote]', function (e) {
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
            $('#tables').DataTable().draw(false);
        });

});




</script>
@endpush
@endsection
