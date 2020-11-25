@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'profile'
])

@section('content')
    <div class="content">
        <div class="row">
            <div class="col-md-8 text-center">
                <form class="col-md-12" action="{{ route('request.update',$request->id) }}" method="POST" >
                    @method('PATCH')
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <h5 class="title">{{$request->account_name}}</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <label class="col-md-3 col-form-label">{{ __('Account Number') }}</label>
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <input type="text" name="account_number" class="form-control" value='{{$request->account_number}}'  required>
                                    </div>
                                    @if ($errors->has('account_number'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('account_number') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="row">
                                <label class="col-md-3 col-form-label">{{ __('Account Name') }}</label>
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <input type="text" name="account_name" class="form-control" value='{{$request->account_name}}' required>
                                    </div>
                                    @if ($errors->has('account_name'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('account_name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                             <div class="row">
                                <label class="col-md-3 col-form-label">{{ __('Card Type Requested') }}</label>
                                <div class="col-md-9">
                                    <div class="form-group">
                                    <select name="cards" id="cards" class="form-control @error('cards') is-invalid @enderror" required autofocus>
                                        <option >Choose Your Card Type</option>
                                        <option value="saphire">Sapphire</option>
                                        <option value="silver">Silver</option>
                                        <option value="gold">Gold</option>
                                    </select>
                                    </div>
                                    @if ($errors->has('cards'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('cards') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="row">
                                <label class="col-md-3 col-form-label">{{ __('Request Type') }}</label>
                                <div class="col-md-9">
                                    <div class="form-group">
                                    <select name="request_type" id="request_type" class="form-control @error('request_type') is-invalid @enderror" required autofocus>
                                    <option >Choose Your Request Type</option>
                                    <option value="pin_change">Change Your Pin</option>
                                    <option value="new_card">New Card Request</option>
                                    <option value="block_card">Block Card</option>
                                    <option value="renew_card">Renew Card</option>
                                    </select>
                                    </div>
                                    @if ($errors->has('request_type'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('request_type ') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                             <div class="row">
                                <label class="col-md-3 col-form-label">{{ __('Is this a New Account') }}</label>
                                <div class="col-md-9">
                                    <div class="form-group">
                                    <select name="account_type" id="account_type" class="form-control " required autofocus>
                                        <option >Is this a New Account</option>
                                        <option value="new">Yes</option>
                                        <option value="old">No</option>
                                    </select>
                                    </div>
                                    @if ($errors->has('account_type'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('account_type ') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <input name="branch_id" id="branch_id"   value='{{ auth()->user()->branch_id }}'required hidden>
                            <input name="done_by" id="done_by" value='{{ auth()->user()->employee_id }}'required hidden>


                            <div class="row">
                                <label class="col-md-3 col-form-label" >{{ __('Requested By') }}</label>
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <input type="text" name="requested_by" class="form-control" value='{{$request->requested_by}}' required>
                                    </div>
                                    @if ($errors->has('requested_by'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('requested_by') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="card-footer ">
                            <div class="row">
                                <div  class="col-sm-4  text-center">
                                    <a class="btn btn-info btn-round text-white" href="{{ url()->previous() }}">{{ __('Go Back') }}</a>
                                    </div>
                                <div class="col-sm-4 text-center">
                                    <button type="submit" class="btn btn-info btn-round" style="background-color: #15224c">{{ __('Update Request') }}</button>
                                </div>

                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
