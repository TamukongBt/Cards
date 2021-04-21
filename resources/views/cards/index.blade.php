@extends('layouts.app', [
'class' => '',
'elementActive' => 'cards'
])

@section('title')
Cards
@endsection

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Cards</h4>
                    <div class="text-right" style='float:right;'>
                        <!-- Button trigger modal -->
                        <a href=# class="btn  btn-primary" type="button" data-toggle="modal" data-target="#modelId" style="background-color: #15224c">Add A Card</a>
                    </div>
                    <div class="card-body">
                    </div>
                    <div class="table-responsive">
                        <table id="tables1" class="table ">
                            <thead>

                                <th>
                                  Cards
                                </th>
                                <th>
                                   Card Slug
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
                    <h5 class="modal-title">{{ __('Add New Card') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                    <form class="col-md-12" action="{{ route('cards.store') }}" method="POST">
                        @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-row">
                                        <div class="col">
                                            <label class=" col-form-label">{{ __('Card Name') }}</label>
                                            <input type="text" name="name" class="form-control"
                                                placeholder="Card Name" required>
                                        </div>
                                        <div class="col">
                                            <label class=" col-form-label">{{ __('Card Slug') }}</label>
                                            <input type="text" name="card_type" class="form-control"
                                                placeholder="Card Slug" required>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary btn-round" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-info btn-round">{{ __('Create Card') }}</button>
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
            "serverSide": false,
            "searchable": true,
            "ajax": "/cards_ajax",


            "columns": [
                { "data": "name", name: 'Branch Name' },
                { "data": "card_type", name: 'Card Slug' },
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
            $('#tables1').DataTable().ajax.reload();
        });
    }else
        alert("You have cancelled!");
});


</script>
@endpush
@endsection
