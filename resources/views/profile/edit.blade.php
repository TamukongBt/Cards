@extends('layouts.app', [
'class' => '',
'elementActive' => 'profile'
])
@php
$role;

if (auth()->user()->department == 'cards') {
    $role = 'Cards and Checks Office';
} elseif (auth()->user()->department == 'css') {
    $role = 'Customer Service Supervisor';
} elseif (auth()->user()->department == 'csa') {
    $role = 'Customer Service Assistant';
} elseif (auth()->user()->department == 'branchadmin') {
    $role = 'Branch / Sales Manager';
} elseif (auth()->user()->department == 'superadmin') {
    $role = 'Super Admin';
}
@endphp

@section('title')
    Edit Profile
@endsection

@section('content')
    <div class="content">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
        @if (session('password_status'))
            <div class="alert alert-success" role="alert">
                {{ session('password_status') }}
            </div>
        @endif
        <div class="row">
            <div class="col-md-4">
                <div class="card card-user">
                    <div class="image">
                        <img src="{{ asset('paper/img/damir-bosnjak.jpg') }}" alt="...">
                    </div>
                    <div class="card-body">
                        <div class="author">
                            <a href="#">
                                <img class="avatar border-gray" src="{{ asset('paper/img/mike.jpg') }}" alt="...">

                                <h5 class="title">{{ __(auth()->user()->name) }}</h5>
                            </a>
                            <p class="description">
                                Employee ID: {{ __(auth()->user()->employee_id) }}
                            </p>
                        </div>
                        <p class="description text-center">
                            {{ __('Union Bank Of Cameroon ') }}
                            <br> {{ $role }}
                            <br> {{ __(auth()->user()->branch->name) }}
                        </p>
                    </div>

                </div>
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ __('Team Members') }}</h4>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled team-members">
                            @if (count($colleagues) == 0)
                                <li>
                                    <div class="row">

                                        <div class="col-md-7 col-7 text-muted">
                                            {{ __('You have No friends, Shame.... ') }}
                                            <br />

                                        </div>

                                    </div>
                                </li>
                            @else
                                @foreach ($colleagues as $colleague)
                                    <li>
                                        <div class="row">
                                            <div class="col-md-2 col-2">
                                                <div class="avatar">
                                                </div>
                                            </div>
                                            <div class="col-md-7 col-7">
                                                {{ $colleague->name }}
                                                <br />
                                                <span class="text-muted">

                                                    <small><?php
                                                        $department = '';
                                                        if ($colleague->department == 'branchadmin') {
                                                        echo 'Branch/Sales Manager';
                                                        } elseif ($colleague->department == 'cards') {
                                                        echo 'Cards and Checks Office';
                                                        } elseif ($colleague->department == 'csa') {
                                                        echo 'Customer Service Assistant';
                                                        } elseif ($colleague->department == 'dso') {
                                                        echo 'Digital Sales Officer';
                                                        } elseif ($colleague->department == 'css') {
                                                        echo 'Customer Service Supervisor';
                                                        } elseif (auth()->user()->department == 'superadmin') {
                                                        $role = 'Super Admin';
                                                        }
                                                        ?></small>
                                                </span>
                                            </div>
                                            <div class="col-md-3 col-3 text-right">
                                                <a href="mailto:{{ $colleague->email }}"> <button
                                                        class="btn btn-sm btn-outline-success btn-round btn-icon"><i
                                                            class="fa fa-envelope"></i></button></a>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            @endif

                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-8 text-center">
                <form class="col-md-12" action="{{ route('profile.update') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card">
                        <div class="card-header">
                            <h5 class="title">{{ __('Edit Profile') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <label class="col-md-3 col-form-label">{{ __('Name') }}</label>
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <input type="text" name="name" class="form-control" placeholder="Name"
                                            value="{{ auth()->user()->name }}" required>
                                    </div>
                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-3 col-form-label">{{ __('Email') }}</label>
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <input type="email" name="email" class="form-control" placeholder="Email"
                                            value="{{ auth()->user()->email }}" required>
                                    </div>
                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="card-footer ">
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <button type="submit"
                                        class="btn btn-info btn-round">{{ __('Save Changes') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <form class="col-md-12" action="{{ route('profile.password') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card">
                        <div class="card-header">
                            <h5 class="title">{{ __('Change Password') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <label class="col-md-3 col-form-label">{{ __('Old Password') }}</label>
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <input type="password" name="old_password" class="form-control"
                                            placeholder="Old password" required>
                                    </div>
                                    @if ($errors->has('old_password'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('old_password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-3 col-form-label">{{ __('New Password') }}</label>
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <input type="password" name="password" class="form-control" placeholder="Password"
                                            required>
                                    </div>
                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-3 col-form-label">{{ __('Password Confirmation') }}</label>
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <input type="password" name="password_confirmation" class="form-control"
                                            placeholder="Password Confirmation" required>
                                    </div>
                                    @if ($errors->has('password_confirmation'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="card-footer ">
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <button type="submit"
                                        class="btn btn-info btn-round">{{ __('Save Changes') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <form class="col-md-12" action="{{ route('profile.notify') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card">
                        <div class="card-header">
                            <h5 class="title">{{ __('Change Location') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <label class="col-md-3 col-form-label">{{ __('Old Branch') }}</label>
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <select name="oldbranch"
                                            class="form-control @error('oldbranch') is-invalid @enderror" required
                                            autofocus>
                                            <option selected="true" disabled="disabled">Choose Your Old Branch</option>
                                            <option value="001">Bamenda</option>
                                            <option value="002">Akwa</option>
                                            <option value="003">Limbe</option>
                                            <option value="004">Yaounde</option>
                                            <option value="005">Kumba</option>
                                            <option value="007">Bafoussam</option>
                                            <option value="011">Bonamoussadi</option>
                                            <option value="012">Mboppi</option>
                                        </select>
                                    </div>
                                    @if ($errors->has('oldbranch'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('oldbranch') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="row">
                                <label class="col-md-3 col-form-label">{{ __('New Branch') }}</label>
                                <div class="form-group col-md" id="branch_id">
                                    <select name="newbranch" class="form-control @error('branch_id') is-invalid @enderror"
                                        required autofocus>
                                        <option selected="true" disabled="disabled">Choose Your Branch</option>
                                        <option idvalue="001">Bamenda</option>
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

                            </div>

                        </div>
                        <div class="card-footer ">
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <button type="submit"
                                        class="btn btn-info btn-round">{{ __('Save Changes') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
