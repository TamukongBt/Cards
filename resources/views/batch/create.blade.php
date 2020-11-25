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
                                    <input type="text" name="start_acct" class="form-control"
                                        placeholder="First Account in Batch" required>
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
                                        <option>Choose Your Card Type</option>
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
                            <label class="col-md-3 col-form-label">{{ __('End Account') }}</label>
                            <div class="col-md-9">
                                <div class="form-group">
                                    <input type="text" name="end_acct" class="form-control"
                                        placeholder="Last Account in Batch" required>
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
                            <label class="col-md-3 col-form-label">{{ __('Cards Details') }}</label>

                            <div class="form-row">
                                <div class="col">
                                    <label class=" col-form-label"><span style="color: goldenrod; font-size: 15px; padding-right: .5rem; "> <i class="fa fa-circle" aria-hidden="true"></i></span>{{ __('Gold Cards') }}</label>
                                    <input type="text" name="gold" class="form-control"
                                        placeholder="Gold Slots" required>
                                </div>
                                <div class="col">
                                    <label class=" col-form-label"><span style="color: silver; font-size: 15px; padding-right: .5rem; "> <i class="fa fa-circle" aria-hidden="true"></i></span>{{ __('Silver Cards') }}</label>
                                    <input type="text" name="silver" class="form-control"
                                        placeholder="Silver Slots" required>
                                </div>
                                <div class="col">
                                    <label class=" col-form-label"><span style="color: #0f52ba; font-size: 15px; padding-right: .5rem; "> <i class="fa fa-circle" aria-hidden="true"></i></span>{{ __('Sapphire Cards') }}</label>
                                    <input type="text" name="sapphire" class="form-control"
                                        placeholder="Sapphire Slots" required>
                                </div>
                            </div>
                        </div>

                        <input name="done_by" id="done_by" value='{{ auth()->user()->employee_id }}' required hidden>

                        b4

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
@endsection
