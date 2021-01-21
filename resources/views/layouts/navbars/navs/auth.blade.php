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
            <a class="navbar-brand" style="font-size: 170%" href="#pablo">{{ __('Union Bank of Cameroon') }} <SMall>  {{auth()->user()->branch->name}} </SMall></a>
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
                        {{auth()->user()->name}}
                        <p>
                            <span class="d-lg-none d-md-block">{{ __('Stats') }}</span>
                        </p>
                    </a>
                </li>
                <li class="nav-item btn-rotate dropdown">

                    <a class="nav-link dropdown-toggle"  id="navbarDropdownMenuLink"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                        @if (count(auth()->user()->unreadNotifications)>0)
                        <span id="badge" class="badge alert-danger">{{count(auth()->user()->unreadNotifications)}}</span>
                        @endif




                        <i class="nc-icon nc-bell-55"  id="read"> </i>
                        <p>
                            <span class="d-lg-none d-md-block">{{ __('Notificatiions') }}</span>
                        </p>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                       <div class="">
                           <div class="card-body list-group-item">
                                {{-- Display no new notifications message  --}}
                               @if (count(auth()->user()->unreadNotifications)==0)
                               <a href="#"> <span class="dropdown-item list-group text-mute">No New Notifications</span></a>
                               @else
                               {{-- list notifications  --}}
                               @foreach (auth()->user()->unreadNotifications as $notification)
                               @hasanyrole('csa|css')
                               {{-- if its a rejected request  --}}
                               @if ($notification->type=='App\Notifications\RejectRequest')
                               @if (count(auth()->user()->unreadNotifications)==0)
                               <a href="#"> <span class="dropdown-item list-group text-mute">No New Notifications</span></a>
                               @else
                               @foreach($notification->data as $data_item)
                               <a href="/rejected"> <span class="dropdown-item list-group">The Request Made by {{ $data_item['account_name']  }} has been rejected                &nbsp;&nbsp; <br><small class="text-right text-mute"> {{ \Carbon\Carbon::parse($data_item['updated_at'] )->diffForHumans() }}</small></span></a>
                               @endforeach
                               @endif
                               @endif
                               @endrole
                               {{-- if it is a new request for an account  --}}
                               @role('css')
                               @if($notification->type=='App\Notifications\NewRequestNotification')
                               @if (count(auth()->user()->unreadNotifications)==0)
                               <a href="#"> <span class="dropdown-item list-group text-mute">No New Notifications</span></a>
                               @else
                               @foreach($notification->data as $data_item)
                               <span class="dropdown-item list-group">New Request made by {{ $data_item['account_name']  }}  &nbsp;&nbsp; <br><small class="text-right text-mute"> {{ \Carbon\Carbon::parse($data_item['updated_at'] )->diffForHumans() }}</small> </span>
                               @endforeach
                               @endif
                               @endif
                               @if($notification->type=='App\Notifications\CardCollected')
                               @if (count(auth()->user()->unreadNotifications)==0)
                               <a href="#"> <span class="dropdown-item list-group text-mute">No New Notifications</span></a>
                               @else
                               @foreach($notification->data as $data_item)
                               <span class="dropdown-item list-group">A {{ $data_item['card_type']  }}  has been collected make sure you register its pin &nbsp;&nbsp; <br><small class="text-right text-mute"> {{ \Carbon\Carbon::parse($data_item['updated_at'] )->diffForHumans() }}</small> </span>
                               @endforeach
                               @endif
                               @endif
                               @endrole
                               {{-- if it is a batch request that is being made  --}}
                               @if($notification->type=='App\Notifications\BatchNotify')
                               @role('cards')
                               @if (count(auth()->user()->unreadNotifications)==0)
                               <a href="#"> <span class="dropdown-item list-group text-mute">No New Notifications</span></a>
                               @else
                               @foreach($notification->data as $data_item)
                               <span class="dropdown-item list-group">New Batch of cards has been created with number {{ $data_item['batch_number']  }}  &nbsp;&nbsp; <br><small class="text-right text-mute"> {{ \Carbon\Carbon::parse($data_item['updated_at'] )->diffForHumans() }}</small> </span>
                               @endforeach
                               @endif
                               @endrole
                               @endif

                               {{-- if it is a request for new slots  --}}
                               @if($notification->type=='App\Notifications\SlotNotify')
                               @role('it')
                               @if (count(auth()->user()->unreadNotifications)==0)
                               <a href="#"> <span class="dropdown-item list-group text-mute">No New Notifications</span></a>
                               @else

                               @foreach($notification->data as $data_item)
                               <span class="dropdown-item list-group">New Slot of cards have Been requested By Cards & Cheques  &nbsp;&nbsp; <br><small class="text-right text-mute"> {{ \Carbon\Carbon::parse($data_item['updated_at'] )->diffForHumans() }}</small> </span>
                               @endforeach
                               @endif
                               @endrole
                               @endif
                               {{-- // --}}
                               @endforeach
                               @endif
                            </div>
                       </div>
                    </div>
                </li>
                <li class="nav-item btn-rotate dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink2"
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
                $('#badge').hide();
            },

        })

});





</script>
@endpush

