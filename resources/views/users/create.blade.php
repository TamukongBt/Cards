@extends('layouts.app', [
'class' => '',
'elementActive' => 'usercreate'
])

@section('title')
    Add A User
@endsection

@section('content')

    <div class="content">
        <div class="row">
            <div class="col-md-8 text-center">

                <form class="form" method="POST" action="{{ route('user.store') }}">
                    @csrf
                    <div class="card d-flex justify-content-center">
                        <button type="button" class="text-left close" data-dismiss="modal" aria-label="Close"
                            style="margin: 0.3rem;">
                            <span aria-hidden="true"><a style=" background-color: #15224c;" class="btn btn-sm"
                                    href="{{ url()->previous() }}"> <i class="nc-icon nc-minimal-left"></i></a></span>
                        </button>
                        <div class="card-header">
                            <h5 class="title">{{ __('Create A New Usergis') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="nc-icon nc-bank"></i>
                                    </span>
                                </div>
                                <select name="department" id="department"
                                    class="form-control @error('department') is-invalid @enderror" required autofocus>
                                    <option selected="true" disabled="disabled">Choose Your Department</option>
                                    <option value="csa">Customer Service Assistant(CSA)</option>
                                    <option value="branchadmin">Branch/Sales Manager</option>
                                    <option value="dso">Digital Sales Officer</option>
                                    <option value="cards">Cards And Checks</option>
                                </select>
                                @if ($errors->has('department'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('department') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <input type="hidden" name="branch_id" id="headoffice" value="000">
                            <div class="input-group{{ $errors->has('branch_id') ? ' has-danger' : '' }}" id="branch_id">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="nc-icon nc-bank"></i>
                                    </span>
                                </div>
                                <select name="branch_id" class="form-control @error('branch_id') is-invalid @enderror"
                                    required autofocus>
                                    <option selected="true" disabled="disabled">Choose Your Branch</option>
                                    <option value="001">Bamenda</option>
                                    <option value="002">Akwa</option>
                                    <option value="003">Limbe</option>
                                    <option value="004">Yaounde</option>
                                    <option value="005">Kumba</option>
                                    <option value="007">Bafoussam</option>
                                    <option value="011">Bonamoussadi</option>
                                    <option value="012">Mboppi</option>
                                </select>
                                @if ($errors->has('branch_id'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('branch_id') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="input-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="nc-icon nc-single-02"></i>
                                    </span>
                                </div>
                                <input name="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                    placeholder="Name" value="{{ old('name') }}" required autofocus>
                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="input-group{{ $errors->has('employee_id') ? ' has-danger' : '' }}">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="nc-icon nc-single-02"></i>
                                    </span>
                                </div>
                                <input name="employee_id" type="text"
                                    class="form-control @error('employee_id') is-invalid @enderror"
                                    placeholder="Employee id" value="{{ old('employee_id') }}" required>
                                @if ($errors->has('employee_id'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('employee_id') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="input-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="nc-icon nc-email-85"></i>
                                    </span>
                                </div>
                                <input name="email" type="email" class="form-control" placeholder="Email" required
                                    value="{{ old('email') }}">
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="input-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="nc-icon nc-key-25"></i>
                                    </span>
                                </div>
                                <input name="password" type="password" class="form-control" placeholder="Password" required>
                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="nc-icon nc-key-25"></i>
                                    </span>
                                </div>
                                <input name="password_confirmation" type="password" class="form-control"
                                    placeholder="Password confirmation" required>
                                @if ($errors->has('password_confirmation'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="card-footer ">
                            <div class="">
                                <div class="">
                                    <button type="submit" class="btn btn-warning btn-round"
                                        style="background-color: #15224c">{{ __('Create User') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            </form>

        </div>
    </div>
    </div>


@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            demo.checkFullPageBackgroundImage();


        });




        $(document).ready(function() {
            $('#headoffice').hide()
            $('#branch_id').hide()
        });

        $('#department').on('change', function() {
            var selection = $(this).val();
            //;
            switch (selection) {
                case 'css':
                    $('#branch_id').show(),
                        $('#headoffice').remove()
                    break;
                case 'csa':
                    $('#branch_id').show(),
                        $('#headoffice').remove()
                    break;
                case 'branchadmin':
                    $('#branch_id').show(),
                        $('#headoffice').remove()
                    break;
                default:
                    $('#headoffice').show()
                    $('#branch_id').remove()
            }
        });

    </script>
@endpush
