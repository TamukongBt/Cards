@extends('layouts.app', [
'class' => '',
'elementActive' => 'profile'
])

@section('content')
<div class="content">
    <div class="row">
        <div class="col-md-8 text-center">
            <form class="col-md-12" action="{{ route('slots.store') }}" method="POST">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h5 class="title">{{ __('New Slots Request') }}</h5>
                    </div>

                    <div class="card-body">
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
