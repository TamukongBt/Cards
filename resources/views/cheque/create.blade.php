@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'profile'
])

@section('content')
    <div class="content">
        <div class="row">

            <div class="col-md-8 text-center">

                <form class="col-md-12" action="{{ route('cheque.store') }}" method="POST" enctype="multipart/form-data" >
                    @csrf
                    <div class="card">
                        <button type="button" class="text-left close" data-dismiss="modal" aria-label="Close" style="margin: 0.3rem;" >
                            <span aria-hidden="true"><a  style=" background-color: #15224c;" class="btn btn-sm" href="{{ url()->previous() }}"> <i class="nc-icon nc-minimal-left"></i></a></span>
                        </button>
                        <div class="card-header">
                            <h5 class="title">{{ __('Create New Cheque Transmissions') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="file" name="file" class="form-control">
                                </div>

                                    @if ($errors->has('file'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('file') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="card-footer ">
                            <div class="form-row">
                                <div class="col">
                                    <button type="submit" class="btn btn-info btn-round" style="background-color: #15224c">{{ __('Upload Cheques') }}</button>
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
        $('#cards').hide()
        break;
        case 'new_card':
        $('#cheques').hide()
        $('#cards').show()
        break;
        default:
        $('#cards').show()

        }
    });

    </script>
    @endpush
@endsection

