@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'profile'
])

@section('content')
    <div class="content">
        <div class="row">

            <div class="col-md-8 text-center">


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
        //;
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

