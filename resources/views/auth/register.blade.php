@extends('layouts.app', [
    'class' => 'register-page',
    'backgroundImagePath' => 'img/bg/jan-sendereks.jpg'
])

@section('content')
    <div class="content">
        <div class="container">
            <div class="row">
                     <div class="col-lg-5 col-md-5 ml-auto">
                    <div class="info-area info-horizontal mt-5">
                        <div class="icon icon-primary">
                            <i class="nc-icon nc-tv-2"></i>
                        </div>
                        <div class="description">
                            <h5 class="info-title">{{ __('Card Request') }}</h5>
                            <p class="description">
                                {{ __('Welcome to our site You can make the request for bank cards here ') }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mr-auto">
                    <div class="card card-signup text-center">
                        <div class="card-header ">
                            <h4 class="card-title">{{ __('Register') }}</h4>
                        </div>
                        <div class="card-body ">
                            <form class="form" method="POST" action="{{ route('register') }}">
                                @csrf




                                    <div class="input-group{{ $errors->has('department') ? ' has-danger' : '' }}">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="nc-icon nc-bank"></i>
                                            </span>
                                        </div>
                                        <select  name="department" id="department" class="form-control @error('department') is-invalid @enderror" required autofocus>
                                            <option selected="true" disabled="disabled">Choose Your Department</option>
                                            <option value="cards">Cards And Checks</option>
                                            <option value="css">Customer Service Supervisor(CSS)</option>
                                            <option value="csa">Customer Service Assistant(CSA)</option>
                                            <option value="it">IT Department</option>
                                        </select>
                                        @if ($errors->has('department'))
                                            <span class="invalid-feedback" style="display: block;" role="alert">
                                                <strong>{{ $errors->first('department') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="input-group{{ $errors->has('branch_id') ? ' has-danger' : '' }}">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="nc-icon nc-bank"></i>
                                            </span>
                                        </div>
                                        <select name="branch_id" id="branch_id" class="form-control @error('branch_id') is-invalid @enderror" required autofocus>
                                            <option  selected="true" disabled="disabled">Choose Your Branch</option>
                                            <option value="000">Head Office</option>
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
                                    <input name="name" type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Name" value="{{ old('name') }}" required autofocus>
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
                                    <input name="employee_id" type="text" class="form-control @error('employee_id') is-invalid @enderror" placeholder="Employee id" value="{{ old('employee_id') }}" required
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
                                    <input name="email" type="email" class="form-control" placeholder="Email" required value="{{ old('email') }}">
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
                                    <input name="password_confirmation" type="password" class="form-control" placeholder="Password confirmation" required>
                                    @if ($errors->has('password_confirmation'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-check text-left">
                                    <label class="form-check-label">
                                        <input class="form-check-input" name="agree_terms_and_conditions" type="checkbox">
                                        <span class="form-check-sign"></span>
                                            {{ __('I agree to the') }}
                                        <a href="#something">{{ __('terms and conditions') }}</a>.
                                    </label>
                                    @if ($errors->has('agree_terms_and_conditions'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('agree_terms_and_conditions') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="card-footer ">
                                    <button type="submit" class="btn btn-info btn-round">{{ __('Get Started') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
             </div>
        </div>
     </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            demo.checkFullPageBackgroundImage();


        });
    </script>
@endpush
