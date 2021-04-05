@extends('layouts.app', [
'class' => '',
'elementActive' => 'profile'
])

@section('content')
<div class="content">
    <div class="row">
        <div class="col-md-8 text-center">
            <form class="col-md-12" action="{{ route('batch.store') }}" method="POST">
                @csrf
                <div class="card">

                    <div class="card-header">
                        <h5 class="title">{{ __('New Batch of Cards') }}</h5>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <label class="col-md-3 col-form-label">{{ __('Start Account') }}</label>
                            <div class="col-md-9">
                                <div class="form-group">
                                    <select  name="start_acct"
                                        class="livesearch form-control @error('start_acct') is-invalid @enderror" required
                                        autofocus>
                                    </select>
                                </div>
                                @if ($errors->has('start_acct'))
                                <span class="invalid-feedback" style="display: block;" role="alert">
                                    <strong>{{ $errors->first('start_acct') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-3 col-form-label">{{ __('Start Card Type Requested') }}</label>
                            <div class="col-md-9">
                                <div class="form-group">
                                    <select name="start_cards"
                                        class="form-control @error('start_cards') is-invalid @enderror" required
                                        autofocus>
                                        <option selected="true" disabled="disabled">Choose Your Card Type</option>
                                        <option value="saphire">Sapphire</option>
                                        <option value="silver">Silver</option>
                                        <option value="gold">Gold</option>
                                    </select>
                                </div>
                                @if ($errors->has('start_cards'))
                                <span class="invalid-feedback" style="display: block;" role="alert">
                                    <strong>{{ $errors->first('start_cards') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <label class="col-md-3 col-form-label">{{ __('Start Account Creation Date') }}</label>
                            <div class="col-md-9">
                                <div class="form-group">
                                    <input type="date" name="start_acctdate" class="form-control"
                                        placeholder="Last Account in Batch" required>
                                </div>
                                @if ($errors->has('start_acctdate'))
                                <span class="invalid-feedback" style="display: block;" role="alert">
                                    <strong>{{ $errors->first('start_acctdate') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <label class="col-md-3 col-form-label">{{ __('End Account') }}</label>
                            <div class="col-md-9">
                                <div class="form-group">
                                    <select  name="end_acct"
                                        class="livesearch2 form-control @error('end_acct') is-invalid @enderror" required
                                        autofocus>
                                    </select>
                                </div>
                                @if ($errors->has('end_acct'))
                                <span class="invalid-feedback" style="display: block;" role="alert">
                                    <strong>{{ $errors->first('end_acct') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <label class="col-md-3 col-form-label">{{ __('End Card Type Requested') }}</label>
                            <div class="col-md-9">
                                <div class="form-group">
                                    <select name="end_cards"
                                        class="form-control @error('end_cards') is-invalid @enderror" required
                                        autofocus>
                                        <option>Choose Your Card Type</option>
                                        <option value="saphire">Sapphire</option>
                                        <option value="silver">Silver</option>
                                        <option value="gold">Gold</option>
                                    </select>
                                </div>
                                @if ($errors->has('end_cards'))
                                <span class="invalid-feedback" style="display: block;" role="alert">
                                    <strong>{{ $errors->first('end_cards') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <label class="col-md-3 col-form-label">{{ __('End Account Creation Date') }}</label>
                            <div class="col-md-9">
                                <div class="form-group">
                                    <input type="date" name="end_acctdate" class="form-control"
                                        placeholder="Last Account in Batch" required>
                                </div>
                                @if ($errors->has('end_acctdate'))
                                <span class="invalid-feedback" style="display: block;" role="alert">
                                    <strong>{{ $errors->first('end_acctdate') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <input name="done_by" id="done_by" value='{{ auth()->user()->employee_id }}' required hidden>

                    </div>


                    <div class="card-footer ">
                        <div class="row">
                            <div class="col-sm-4  text-center">
                                <a class="btn btn-info btn-round text-white"
                                    href="{{ url()->previous() }}">{{ __('Go Back') }}</a>
                            </div>
                            <div class="col-sm-4 text-center">
                                <button type="submit" class="btn btn-info btn-round">{{ __('Create Request') }}</button>
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



    $('.livesearch').select2({
        placeholder: 'Choose Start Account Number',
        ajax: {
            url: '/autosearch',
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {

                            text: item.account_number+' , '+item.accountname+' , '+item.cards+' , '+item.date,
                            id: item.id
                        }
                    })
                };
            },
            cache: true
        }
    });

+
    $('.livesearch2').select2({
        placeholder: 'Choose End Account Number',
        ajax: {
            url: '/autosearch',
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.account_number+' , '+item.accountname+' , '+item.cards+' , '+item.date,
                            id: item.account_number
                        }
                    })
                };
            },
            cache: true
        }
    });


</script>
@endpush
@endsection
