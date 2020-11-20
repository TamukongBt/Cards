@extends('layouts.app', [
'class' => '',
'elementActive' => 'tables'
])

@section('content')
<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title"> Request Tables</h4>
                    <div class="text-right" style='float:right;'>
                        <a href="request/create" class="btn btn-sm btn-primary">New Request</a>
                    </div>
                    <div class="card-body">
                    </div>
                    <div class="table-responsive">
                        {{-- <table class="table" id="myTable">
                            <thead class=" text-primary">
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
                                <th>
                                    Branch
                                </th>
                                <th>
                                </th>
                                <th>
                                </th>
                                <th>
                                </th>
                            </thead>
                            <tbody>
                                @foreach ($request as $entry)

                            <tbody>
                                <tr>
                                    <td>{{ $entry->account_number}}
                                        </a></td>
                                    <td>{{ $entry->account_name }}</a></td>
                                    <td>{{ $entry->request_type }}</td>
                                    <td>{{ $entry->cards }}</td>
                                    <td>{{ $entry->created_at }}</td>
                                    <td>{{ $entry->requested_by }}</td>
                                    <td>{{ $entry->branch_id }}</td>
                                    @auth
                                    @can('validate')
                                    <td><a class="btn btn-outline-primary btn-sm"
                                            href="/request/fulfilled/{{ $entry->id }}"><i class="nc-icon nc-check-2"
                                                aria-hidden="true" style="color: black"></i></a></td>
                                    @endcan
                                    @can('edit')
                                    <td id="float">
                                        <button id="view1" type="button" class="btn btn-outline-dark btn-sm"
                                            style="cursor:pointer;">
                                            <i class="nc-icon nc-simple-info" aria-hidden="true"
                                                style="color: black"></i>
                                        </button>
                                    </td>
                                    <td>
                                        <button id="deletebutton" type="button" class="btn btn-outline-dark btn-sm"
                                            data-toggle="modal" data-target="#delete" style="cursor:pointer;">
                                            <i class="nc-icon nc-simple-remove" aria-hidden="true"
                                                style="color: black"></i>
                                        </button>

                                        <div class="modal fade" id="delete" tabindex="-1" role="dialog"
                                            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered " role="document">
                                                <div class="modal-content">
                                                    <div class="card-header">
                                                        <h5 class="modal-title" id="exampleModalLongTitle">Confirm
                                                            Delete</h5>
                                                        <button href="#" type="button" class="close"
                                                            data-dismiss="modal" aria-label="Close"
                                                            style="margin-top:-25px;cursor:pointer">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="container">
                                                            Are you sure you want to delete this entry
                                                        </div>

                                                    </div>
                                                    <div class="modal-footer float-right">
                                                        <button type="button" class="btn btn-outline-dark btn-sm"
                                                            data-dismiss="modal" style="cursor:pointer;">
                                                            No
                                                        </button>
                                                        <form id="deletelink" method="post">
                                                            {{csrf_field()}}
                                                            <input name="_method" type="hidden" value="DELETE">
                                                            <button class="btn btn-outline-danger btn-sm"
                                                                type="submit">Yes</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    @endcan
                                    @endauth
                                </tr>
                            </tbody>
                            @endforeach
                        </table> --}}
                        <table id="table1" class="table table-striped">
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
                                <th>
                                    Branch
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

<!-- Modal to view -->
{{-- <div class="modal fade" id="viewmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered " role="document">
        <div class="modal-content">
            <div class="card-header">
                <h5 class="modal-title" id="exampleModalLongTitle"><span id="accountname_title"></span> <a
                        href="{{ route('request.edit',$entry->id)}}"><i class="fa fa-pencil text-dark"
                            aria-hidden="true"></i></a></h5>

                <button href="#" type="button" class="close" data-dismiss="modal" aria-label="Close"
                    style="margin-top:-25px;cursor:pointer">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="content">
                        <div class="row">
                            <div class="col-md-9 text-center">
                                <div class="row">
                                    <label class="col-md-6 col-form-label">{{ __('Account Number:') }}</label>
                                    <div class="form-group">
                                        <span id="account_number"></span>
                                    </div>
                                </div>

                                <div class="row">
                                    <label class="col-md-6 col-form-label">{{ __('Account Name') }}</label>
                                    <div class="form-group">
                                        <span id="account_name"></span>
                                    </div>
                                </div>

                                <div class="row">
                                    <label class="col-md-6 col-form-label">{{ __('Card Type Requested') }}</label>
                                    <div class="form-group">
                                        <span id="card_type"></span>
                                    </div>
                                </div>

                                <div class="row">
                                    <label class="col-md-6 col-form-label">{{ __('Request Type') }}</label>
                                    <div class="form-group">
                                        <span id="request_type"></span>
                                    </div>
                                </div>

                                <div class="row">
                                    <label class="col-md-6 col-form-label">{{ __('Date Requested') }}</label>
                                    <div class="form-group">
                                        <span id="requested_date"></span>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-6 col-form-label">{{ __('Requested by:') }}</label>
                                    <div class="form-group">
                                        <span id="requested_by"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> --}}

@push('scripts')

<script type="text/javascript">

    // This script is used in passing data from the table directly to form in the book hall page
    // var table = $('#myTable').DataTable();
    $(document).ready(function () {
        $('#table1').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "/ajax",

            "columns": [
                { "data": "account_number", name: 'Account Number' },
                { "data": "account_name", name: 'Account Name' },
                { "data": "request_type", name: 'Request Type' },
                { "data": "cards", name: 'Cards Requested' },
                { "data": "created_at", name: 'Requested Date' },
                { "data": "requested_by", name: 'Requested By' },
                { "data": "branch_id", name: 'Branch' },
                {
                    data: 'action', name: 'action', orderable: true, searchable: true
                },


            ]
        });
    });


    //Start Edit Record

    $('#table1 tbody').on('click', '#view', function () {


        var currow = $(this).closest('tr');
        var col1 = currow.find('td:eq(0)').text();
        var col2 = currow.find('td:eq(1)').text();
        var col3 = currow.find('td:eq(2)').text();
        var col4 = currow.find('td:eq(3)').text();
        var col5 = currow.find('td:eq(4)').text();
        var col6 = currow.find('td:eq(5)').text();
        var col7 = currow.find('td:eq(6)').text();
        var data = col1 + '\n' + col2 + '\n' + col3 + '\n' + col4 + '\n' + col5 + '\n' + col6;
        console.log(data);

        $('#account_number').text(col1);
        $('#account_name').text(col2);
        $('#accountname_title').text(col2);
        $('#card_type').text(col3);
        $('#request_type').text(col4);
        $('#account_type').text(col5);
        $('#requested_date').text(col6);
        $('#requested_by').text(col7);


    });

    $("#deletebutton").click(function () {
        var currow = $(this).closest('tr');
        var col1 = currow.find('td:eq(0)').text();

        $("#deletelink").attr("action", "{{  route('request.destroy'," + col1 + ")}}");
    });


</script>
@endpush
@endsection
