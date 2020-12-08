<nav class="navbar navbar-expand-lg navbar-absolute fixed-top navbar-transparent">
    <div class="container-fluid">
        <div class="navbar-wrapper">
            <div class="navbar-toggle">
                <button type="button" class="navbar-toggler">
                    <span class="navbar-toggler-bar bar1"></span>
                    <span class="navbar-toggler-bar bar2"></span>
                    <span class="navbar-toggler-bar bar3"></span>
                </button>
            </div>
            <a class="navbar-brand" href="#pablo">{{ __('Cards Request') }}</a>
        </div>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation"
            aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navigation">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link btn-magnify" href="#pablo">
                        <i class="nc-icon nc-layout-11"></i>
                        <p>
                            <span class="d-lg-none d-md-block">{{ __('Stats') }}</span>
                        </p>
                    </a>
                </li>
                <li class="nav-item btn-rotate dropdown">
                    <a class="nav-link dropdown-toggle"  id="navbarDropdownMenuLink"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        @if (count(auth()->user()->unreadNotifications)>0)
                         <span id="badge" class="badge alert-danger">{{count(auth()->user()->notifications)}}</span>
                        @endif
                        <i class="nc-icon nc-bell-55" id="read"> </i>
                        <p>
                            <span class="d-lg-none d-md-block">{{ __('Some Actions') }}</span>
                        </p>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                       <div class="">
                           <div class="card-body list-group-item">
                            @foreach (auth()->user()->notifications as $notification)
                            @if ($notification->type='App\Notifications\RejectRequest')
                            @foreach($notification->data as $data_item)
                           <a href="/rejected"></a>
                            @endforeach
                            @else
                            @foreach($notification->data as $data_item)
                            <span class="dropdown-item list-group">New Batch of cards has been created with number{{ $data_item['batch_number']  }} </span>
                            @endforeach
                            @endif
                            @endforeach

                           </div>
                       </div>
                    </div>
                </li>
                <li class="nav-item btn-rotate dropdown">
                    <a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink2"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="nc-icon nc-settings-gear-65"></i>
                        <p>
                            <span class="d-lg-none d-md-block">{{ __('Account') }}</span>
                        </p>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink2">
                        <form class="dropdown-item" action="{{ route('logout') }}" id="formLogOut" method="POST" style="display: none;">
                            @csrf
                        </form>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" onclick="document.getElementById('formLogOut').submit();">{{ __('Log out') }}</a>
                            <a class="dropdown-item" href="{{ route('profile.edit') }}">{{ __('My profile') }}</a>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>
@push('scripts')

<script type="text/javascript">


// Mark as Read

    $('#read').click(function (e) {
    e.preventDefault();
     $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    $.ajax({
            url: '/read_ajax',
            type:"GET",
            dataType: 'json',
            success: function (data) {
                console.log('na me dis ');
            },

        })

});





</script>
@endpush

