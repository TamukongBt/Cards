@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'profile'
])
@section('title')
Edit Request
@endsection
@section('content')
    <div class="content">
        <div class="card">
            <div class="card-header">
                <button type="button" class="text-left close" data-dismiss="modal" aria-label="Close" style="margin: 0.3rem;" >
                    <span aria-hidden="true"><a  style=" background-color: #15224c;" class="btn btn-sm" href="{{ url()->previous() }}"> <i class="nc-icon nc-minimal-left"></i></a></span>
                </button>
                <h5 class="title text-center">{{$request->accountname}}</h5>
            </div>
            <div class="text-center">
                <form class="col-md-12" action="{{ route('cardrequest.update',$request->id) }}" method="POST" >
                    @method('PATCH')
                    @csrf

                    <div class="card-body ">

                        <div class="row">

                            <div class="col-md">
                                <div class="form-group">
                                    <input type="text" name="accountname" class="form-control" placeholder="Account Name"  value='{{$request->accountname}}'  >
                                </div>
                                @if ($errors->has('account_name'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('account_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-sm">
                                <div class="form-group">
                                    <label class="col-sm">{{ __('Bank Code') }}</label>
                                    <input type="text" name="bankcode" class="form-control" value='{{$request->bankcode}}'required>
                                </div>
                                @if ($errors->has('bankcode'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('bankcode') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-sm">
                                <div class="form-group">
                                    <label class="col-sm">{{ __('Branch Code') }}</label>
                                    <input type="text" name="branchcode" class="form-control"   id="branchcode" value="{{$request->branchcode}}" required>
                                </div>
                                @if ($errors->has('bbranchcode'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('branchcode') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-sm">
                                <div class="form-group">
                                    <label class="col-sm">{{ __('Account No') }}</label>
                                    <input type="text" name="account_number" class="form-control" maxlength="11"   value='{{$request->account_number}}' required>
                                </div>
                                @if ($errors->has('account_number'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('account_number') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-sm">
                                <div class="form-group">
                                    <label class="col-sm">{{ __('RIB') }}</label>
                                    <input type="text" name="RIB" class="form-control"   value='{{$request->RIB}}' required>
                                </div>
                                @if ($errors->has('account_number'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('RIB') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md">
                                <div class="form-group">
                                    <select name="request_type" id="request_type" class="form-control @error('request_type') is-invalid @enderror"   required autofocus>
                                        <option selected="true" disabled="disabled">Choose Your Request Type</option>
                                        {{-- <option value="cheque_25">New </option> --}}
                                        <option value="new_card">Card Renewal</option>
                                        <option value="renew_card">Card Subscription</option>
                                        <option value="pin_change">Change Your Pin</option>
                                        <option value="block_card">Block Card</option>
                                    </select>
                                </div>
                                @if ($errors->has('request_type'))
                                <span class="invalid-feedback" style="display: block;" role="alert">
                                    <strong>{{ $errors->first('request_type ') }}</strong>
                                </span>
                                @endif
                            </div>

                           <div class="col-md">
                               <div class="form-group">
                               <select name="cards" id="cards" class="form-control @error('cards') is-invalid @enderror"  required autofocus>
                                   <option selected="true" disabled="disabled">Choose Your Card Type</option>
                                   <option value="saphire">Trust Saphir</option>
                                   <option value="silver">Trust Silver</option>
                                   <option value="gold">Trust Gold</option>
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
                            <div class="col-md">
                                <div class="form-group">
                                <select name="account_type" id="account_type" class="form-control "  required autofocus>
                                    <option selected="true" disabled="disabled">Account Type</option>
                                    <option value="individual">Individual Account</option>
                                    <option value="moral">Moral Entity</option>
                                </select>
                                </div>
                                @if ($errors->has('account_type'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('account_type ') }}</strong>
                                    </span>
                                @endif
                            </div>


                        <input name="done_by" id="done_by" value='{{ $request->done_by }}'required hidden>
                        <input name="branch_id" id="branch_id" value='{{ auth()->user()->branch_id }}'required hidden>


                            <div class="col-md">
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

                        <div class="row">
                            <div class="col-md">
                                <div class="form-group">
                                    <input type="email" name="email" class="form-control" value='{{$request->email}}'  required>
                                </div>
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md">
                                <div class="form-group">
                                    <input type="tel" name="tel" class="form-control" value='{{$request->tel}}' required>
                                </div>
                                @if ($errors->has('requested_by'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('tel') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-footer ">
                        <div class="form-row">
                            <div class="col">
                                <button type="submit" class="btn btn-warning btn-round" style="background-color: #15224c">{{ __('Update Request') }}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


@endsection
