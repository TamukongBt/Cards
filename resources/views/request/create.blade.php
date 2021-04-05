@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'profile'
])

@section('content')
    <div class="content">
        <div class="row">

            <div class="col-md-8 text-center">

                <form class="col-md-12" action="{{ route('request.store') }}" method="POST" >
                    @csrf
                    <div class="card">
                        <button type="button" class="text-left close" data-dismiss="modal" aria-label="Close" style="margin: 0.3rem;" >
                            <span aria-hidden="true"><a  style=" background-color: #15224c;" class="btn btn-sm" href="{{ url()->previous() }}"> <i class="nc-icon nc-minimal-left"></i></a></span>
                        </button>
                        <div class="card-header">
                            <h5 class="title">{{ __('Make a new Request') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <label class="col-md-3 col-form-label">{{ __('Account Number') }}</label>
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <input type="text" name="account_number" class="form-control" placeholder="Account Number"  required>
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
                                        <input type="text" name="accountname" class="form-control" placeholder="Account Name"  required>
                                    </div>
                                    @if ($errors->has('accountname'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('accountname') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>


                            <div class="row">
                                <label class="col-md-3 col-form-label">{{ __('Request Type') }}</label>
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <select name="request_type" id="request_type" class="form-control @error('request_type') is-invalid @enderror" required autofocus>
                                            <option selected="true" disabled="disabled">Choose Your Request Type</option>
                                            {{-- <option value="cheque_25">New </option> --}}
                                            <option value="cheque">New Cheque Request</option>
                                            <option value="new_card">New Card Request</option>
                                            <option value="pin_change">Change Your Pin</option>
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



                            <div class="row" id="cards">
                               <label class="col-md-3 col-form-label">{{ __('Card Type Requested') }}</label>
                               <div class="col-md-9">
                                   <div class="form-group">
                                   <select name="cards" id="cards" class="form-control @error('cards') is-invalid @enderror" required autofocus>
                                       <option selected="true" disabled="disabled">Choose Your Card Type</option>
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

                           <div class="row" id="cheques">
                            <label class="col-md-3 col-form-label">{{ __('Cheque Type Requested') }}</label>
                            <div class="col-md-9">
                                <div class="form-group">
                                <select name="cards" id="cheques" class="form-control @error('cheque') is-invalid @enderror" required autofocus>
                                    <option selected="true" disabled="disabled">Choose Your Cheque Type</option>
                                    <option value="certified">Certified Cheque</option>
                                    <option value="cheque_50">Cheque 50</option>
                                    <option value="cheque_25">Cheque 25</option>
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
                                <label class="col-md-3 col-form-label">{{ __('Is this a New Account') }}</label>
                                <div class="col-md-9">
                                    <div class="form-group">
                                    <select name="account_type" id="account_type" class="form-control " required autofocus>
                                        <option selected="true" disabled="disabled">Is this a New Account</option>
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
                                <label class="col-md-3 col-form-label">{{ __('Requested By') }}</label>
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <input type="text" name="requested_by" class="form-control" placeholder="Requested By"  required>
                                    </div>
                                    @if ($errors->has('requested_by'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('requested_by') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="row">
                                <label class="col-md-3 col-form-label">{{ __('Email') }}</label>
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <input type="email" name="email" class="form-control" placeholder="Email Address"  required>
                                    </div>
                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="row">
                                <label class="col-md-3 col-form-label">{{ __('Telephone Number') }}</label>
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <input type="tel" name="tel" class="form-control" placeholder="Telephone Number"  required>
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
                                    <button type="submit" class="btn btn-info btn-round" style="background-color: #15224c">{{ __('Create Request') }}</button>
                                </div>

                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @push('scripts')

    <script type="text/javascript">

$(document).ready(function () {
    $('#cheques').hide()
        $('#cards').hide()
    });

        $('#request_type').on('change',function(){
        var selection = $(this).val();
        console.log(selection);
        switch(selection){
        case 'cheque':
        $('#cheques').show(),
        $('#cards').remove()
        break;
        case 'new_card':
        $('#cheques').remove()
        $('#cards').show()
        break;
        default:
        $('#cards').show()

        }
    });

    </script>
    @endpush
@endsection

