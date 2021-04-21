@extends('layouts.app', [
'class' => '',
'elementActive' => 'userindex'
])

@section('title')
Users
@endsection

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">  Users Table </h4>

                    <div class="text-right" style='float:right;'>
                        <a href="user/create" class="btn  btn-primary" style="background-color: #15224c">New User</a>
                    </div>
                    <div class="card-body">
                    </div>
                    <div class="table-responsive">
                        <table id="table1" class="table">
                            <thead>
                                <th style="font-size: 0.938em;">
                                   Name
                                </th>
                                <th style="font-size: 0.95em;">
                                   Employee ID
                                 </th>
                                <th>
                                    Department
                                </th>
                                <th>
                                    Branch
                                </th>
                                <th>
                                   Email Address
                                </th>
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




            <!-- Modal to get reason for rejecting -->
<div class="modal fade" id="modelreject" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header text-light" style="background-color: #15224c; hover:background-color: gold;">
                            <h5 class="modal-title">{{ __('Change Department') }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span class="text-light " aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form class="col-md-12" action="{{ route('checkrequest.store') }}" method="POST" id="denied">
                                @csrf
                        <div class="col">
                                    <label class=" col-form-label">{{ __('Select New Department') }}</label>
                                    @role('cards')
                                    <select name="department"  class="form-control @error('request_type') is-invalid @enderror"  >
                                        <option selected="true" disabled="disabled">Choose Department</option>
                                        <option value="csa">Customer Service Assistant(CSA)</option>
                                        <option value="branchadmin">Branch/Sales Manager</option>
                                        <option value="dso">Digital Sales Officer</option>
                                        <option value="cards">Cards And Checks</option>
                                    </select>
                                    @endrole
                                    @role('branchadmin')
                                    <select name="department"  class="form-control @error('request_type') is-invalid @enderror"  >
                                        <option selected="true" disabled="disabled">Choose Department</option>
                                        <option value="csa">Customer Service Assistant(CSA)</option>
                                        <option value="branchadmin">Branch/Sales Manager</option>
                                    </select>
                                    @endrole
                                    @role('superadmin')
                                    <select name="department"  class="form-control @error('request_type') is-invalid @enderror"  >
                                        <option selected="true" disabled="disabled">Choose Department</option>
                                        <option value="superadmin">Super Administrator</option>
                                        <option value="csa">Customer Service Assistant(CSA)</option>
                                        <option value="branchadmin">Branch/Sales Manager</option>
                                        <option value="dso">Digital Sales Officer</option>
                                        <option value="cards">Cards And Checks</option>
                                    </select>
                                    @endrole
                                </div>
                                <div class="modal-footer">
                                    <button type="button" style="background-color: #15224c; hover:background-color: gold;" class="btn btn-warning btn-round" data-dismiss="modal">Close</button>
                                    <button id="send" type="button" style="background-color: #15224c; hover:background-color: gold;" class="btn btn-warning btn-round">{{ __('Change') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


@push('scripts')

<script type="text/javascript">
    $(document).ready(function () {
                    $('#table1').DataTable({
                        "processing": true,
                        "serverSide": false,
                        "searchable": true,
                        "responsive": true,
                        "ajax": "/user_ajax",


                        "columns": [
                            { "data": "name", name: 'Name' },
                            { "data": "employee_id", name: 'Employee Id' },
                            { "data": "department", name: 'Department' },
                            { "data": "branch_id", name: 'Branch' },
                            { "data": "email", name: 'Email Address' },
                            {
                                data: 'action', name: 'action', orderable: true, searchable: true
                            },

                        ],
                        'rowCallback': function(row, data, index){
                            if(data.not_active == '0'){
                                $(row).css('background-color', '#9ff99f45');
                            }else{
                                $(row).css('background-color', '#fb1d328c');
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
@hasanyrole('cards|superadmin')
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
                        'The Account Has Been Activated',
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

    send.click(function (e){

        $.ajax({
            url: url,
            type:"POST",
            dataType: 'json',
            data:form.serialize(),
            beforeSend:function()
                {

                       Swal.showLoading();

                    $('#modelreject').modal('hide');

                },

            success: function (data) {
                Swal.hideLoading();
                Swal.close();

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
@endhasanyrole
<script>

$('#table1').on('click', '.track[data-remote]', function (e) {
                    e.preventDefault();
     $.ajaxSetup({
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var url = $(this).data('remote');

    //;

        $.ajax({
            url: url,
            type:"GET",
            dataType: 'json',
            data:{'_method':'GET'},
            success: function (data) {
                Swal.fire(
                       'Approved!',
                        'The Account Has Been Deactivated',
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
