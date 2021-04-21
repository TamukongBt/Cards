@extends('layouts.app', [
'class' => '',
'elementActive' => 'checkcreate'
])

@section('title')
    New Checks Request
@endsection

@section('content')
    <div class="content">
        <div class="row">

            <div class="col-md-8 text-center">

                <form class="col-md-12" action="{{ route('checkrequest.store') }}" method="POST">
                    @csrf
                    <div class="card d-flex justify-content-center">
                        <button type="button" class="text-left close" data-dismiss="modal" aria-label="Close"
                            style="margin: 0.3rem;">
                            <span aria-hidden="true"><a style=" background-color: #15224c;" class="btn btn-sm"
                                    href="{{ url()->previous() }}"> <i class="nc-icon nc-minimal-left"></i></a></span>
                        </button>
                        <div class="card-header">
                            <h5 class="title">{{ __('Request a New Check') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">

                                <div class="col-md">
                                    <div class="form-group">
                                        <input type="text" name="accountname" class="form-control"
                                            placeholder="Account Name" required>
                                    </div>
                                    @if ($errors->has('accountname'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('accountname') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-sm">
                                    <div class="form-group">
                                        <label class="col-sm">{{ __('Bank Code') }}</label>
                                        <input type="text" name="bankcode" id="bankcode" class="form-control" value="10023"
                                            required>
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
                                        <input type="text" name="branchcode" class="form-control" id="branchcode" required>
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
                                        <input type="text" name="account_number" id="acc_num" class="form-control"
                                            maxlength="11" required>
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
                                        <input type="text" name="RIB" class="form-control" id="RIB" required>
                                    </div>
                                    <span class="invalid-feedback" role="alert" id="show">
                                        <strong>Check Account Data</strong>
                                    </span>
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
                                        <select name="account_type" id="account_type" class="form-control " required
                                            autofocus>
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

                                <div class="col-md">
                                    <div class="form-group">
                                        <select name="checks" id="checks"
                                            class="form-control @error('checks') is-invalid @enderror" required autofocus>
                                            <option selected="true" disabled="disabled">Choose Your Check Type</option>
                                            <option value="cheque_25">Cheque 25</option>
                                            <option value="cheque_50">Cheque 50</option>
                                        </select>
                                    </div>
                                    @if ($errors->has('checks'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('checks') }}</strong>
                                        </span>
                                    @endif
                                </div>


                            </div>

                            <div class="row">

                                <div class="col-md">
                                    <div class="form-group">
                                        <input type="number" name="number" placeholder="Number Of Booklets"
                                            class="form-control @error('number') is-invalid @enderror" required autofocus>
                                    </div>
                                    @if ($errors->has('number'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('number') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <input name="done_by" id="done_by" value='{{ auth()->user()->employee_id }}' required
                                    hidden>
                                <input name="branch_id" id="branch_id" value='{{ auth()->user()->branch_id }}' required
                                    hidden>


                                <div class="col-md">
                                    <div class="form-group">
                                        <input type="text" name="requested_by" class="form-control"
                                            placeholder="Requested By" required>
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
                                        <input type="email" name="email" class="form-control" placeholder="Email Address"
                                            required>
                                    </div>
                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="col-md">
                                    <div class="form-group">
                                        <input type="tel" name="tel" class="form-control" placeholder="Telephone Number : 6XXXXXXXX"
                                            maxlength="9"  required>
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
                                    <button type="submit" class="btn btn-warning btn-round"
                                        style="background-color: #15224c">{{ __('Create Request') }}</button>
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
            $(document).ready(function() {
                $('#show').hide();
            });

            $('#branch_id').on('change', function() {
                var selection = $(this).val();
                $('#branchcode').val(selection);
            });

            $('#RIB').on('change', function() {
                var bankcode = $('#bankcode').val();
                var branchcode = $('#branchcode').val();
                var acc_num = $('#acc_num').val();
                var rib = 97 - (((89 * bankcode) + (15 * branchcode) + (3 * acc_num)) % 97)
                console.log(rib);
                if ($('#RIB').val() == rib) {
                    $('#show').hide();
                } else {
                    $('#show').show();
                }
            });

            $('#account_type').on('change', function() {

                if ($('#account_type').val() == 'individual') {
                    $('#checks').val('cheque_25');
                }
            });

        </script>
    @endpush

@endsection
