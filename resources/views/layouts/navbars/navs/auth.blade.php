<nav class="navbar navbar-expand-lg navbar-absolute fixed-top navbar-transparent">

    @php
        $role;
        if (auth()->user()->department == 'cards') {
            $role = 'Cards and Checks Office';
        } elseif (auth()->user()->department == 'dso') {
            $role = 'Digital Sales Officer' . ' ' . auth()->user()->branch->name;
        } elseif (auth()->user()->department == 'csa') {
            $role = 'Customer Service Assistant' . ' ' . auth()->user()->branch->name;
        } elseif (auth()->user()->department == 'branchadmin') {
            $role = 'Branch / Sales Manager' . ' ' . auth()->user()->branch->name;
        } elseif (auth()->user()->department == 'superadmin') {
            $role = 'Super Admin' . ' ' . auth()->user()->branch->name;
        }
    @endphp
    <div class="container-fluid">
        <div class="navbar-wrapper">
            <div class="navbar-toggle">
                <button type="button" class="navbar-toggler">
                    <span class="navbar-toggler-bar bar1"></span>
                    <span class="navbar-toggler-bar bar2"></span>
                    <span class="navbar-toggler-bar bar3"></span>
                </button>
            </div>
            <a class="navbar-brand" style="font-size: 170%" href="#pablo"> {{ $role }} </a>
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
                        {{ auth()->user()->name }}
                        <p>
                            <span class="d-lg-none d-md-block">{{ __('Stats') }}</span>
                        </p>
                    </a>
                </li>
                <li class="nav-item btn-rotate dropdown">

                    <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        @if (count(auth()->user()->unreadNotifications) > 0)
                            <span id="badge"
                                class="badge alert-danger">{{ count(auth()->user()->unreadNotifications) }}</span>
                        @endif




                        <i class="nc-icon nc-bell-55" id="read"> </i>
                        <p>
                            <span class="d-lg-none d-md-block">{{ __('Notificatiions') }}</span>
                        </p>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                        <div class="">
                            <div class="card-body list-group-item">
                                {{-- Display no new notifications message --}}
                                @if (count(auth()->user()->unreadNotifications) == 0)
                                    <a href="#"> <span class="dropdown-item list-group text-mute">No New
                                            Notifications</span></a>
                                @else
                                    {{-- list notifications --}}
                                    @foreach (auth()->user()->unreadNotifications as $notification)
                                        {{-- if it is a request for transfer Approved --}}
                                        @hasanyrole('branchadmin|csa')
                                        @if ($notification->type == 'App\Notifications\TransferApprove')
                                            @if (count(auth()->user()->unreadNotifications) == 0)
                                                <a href="#"> <span class="dropdown-item list-group text-mute">No New
                                                        Notifications</span></a>
                                            @else
                                                <a href="/">
                                                    <span class="dropdown-item list-group">Your Transfer Request has been
                                                        approved &nbsp;&nbsp; <br><small class="text-right text-mute">
                                                            {{ \Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}</small>
                                                    </span>
                                                </a>

                                            @endif
                                            {{-- // --}}
                                        @endif
                                        @endhasanyrole

                                        {{-- Check if notification is for card --}}
                                        @if ($notification->type == 'App\Notifications\CardCollected')
                                            @if (count(auth()->user()->unreadNotifications) == 0)
                                                <a href="#"> <span class="dropdown-item list-group text-mute">No New
                                                        Notifications</span></a>
                                            @else
                                                @foreach ($notification->data as $data_item)
                                                    <a href="#"> <span class="dropdown-item list-group">A Card Has Been
                                                            Collected by {{ $data_item['accountname'] }} &nbsp;&nbsp;
                                                            <br><small class="text-right text-mute">
                                                                {{ \Carbon\Carbon::parse($data_item['updated_at'])->diffForHumans() }}</small></span></a>
                                                @endforeach
                                            @endif
                                        @endif

                                        {{-- if it is a locationchange that is being made --}}
                                        @if ($notification->type == 'App\Notifications\Locationchange')

                                            @role('cards')

                                            @if (count(auth()->user()->unreadNotifications) == 0)
                                                <a href="#"> <span class="dropdown-item list-group text-mute">No New
                                                        Notifications</span></a>

                                            @else
                                                <a href="/change">
                                                    <span class="dropdown-item list-group">Transfer of Location Request
                                                        has been made &nbsp;&nbsp; <br><small
                                                            class="text-right text-mute">
                                                            {{ \Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}</small>
                                                    </span>
                                                </a>


                                            @endif


                                            @endrole
                                            @role('branchadmin')

                                            @if (count(auth()->user()->unreadNotifications) == 0)
                                                <a href="#"> <span class="dropdown-item list-group text-mute">No New
                                                        Notifications</span></a>

                                            @else
                                                <a href="/change">
                                                    <span class="dropdown-item list-group">Transfer of Location Request
                                                        has been made &nbsp;&nbsp; <br><small
                                                            class="text-right text-mute">
                                                            {{ \Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}</small>
                                                    </span>
                                                </a>
                                            @endif
                                            @if ($notification->type == 'App\Notifications\CardCollected')
                                                @if (count(auth()->user()->unreadNotifications) == 0)
                                                    <a href="#"> <span class="dropdown-item list-group text-mute">No New
                                                            Notifications</span></a>
                                                @else
                                                    @foreach ($notification->data as $data_item)
                                                        <a href="#"> <span class="dropdown-item list-group">A Card Has
                                                                Been Collected by {{ $data_item['accountname'] }}
                                                                &nbsp;&nbsp; <br><small class="text-right text-mute">
                                                                    {{ \Carbon\Carbon::parse($data_item['updated_at'])->diffForHumans() }}</small></span></a>
                                                    @endforeach
                                                @endif
                                            @endif

                                            @endrole
                                        @endif

                                        @hasanyrole('csa|branchadmin')
                                        {{-- if its a rejected request --}}
                                        @if ($notification->type == 'App\Notifications\RejectRequest')
                                            @if (count(auth()->user()->unreadNotifications) == 0)
                                                <a href="#"> <span class="dropdown-item list-group text-mute">No New
                                                        Notifications</span></a>
                                            @else
                                                @foreach ($notification->data as $data_item)
                                                    <a href="/rejected"> <span class="dropdown-item list-group">The
                                                            Request Made by {{ $data_item['accountname'] }} has been
                                                            rejected &nbsp;&nbsp; <br><small
                                                                class="text-right text-mute">
                                                                {{ \Carbon\Carbon::parse($data_item['updated_at'])->diffForHumans() }}</small></span></a>
                                                @endforeach
                                            @endif
                                        @endif
                                        @endrole

                                        {{-- if its a Validate User --}}
                                        @if ($notification->type == 'App\Notifications\ValidateUser')
                                            @if (count(auth()->user()->unreadNotifications) == 0)
                                                <a href="#"> <span class="dropdown-item list-group text-mute">No New
                                                        Notifications</span></a>
                                            @else
                                                @foreach ($notification->data as $data_item)
                                                    <a href="/inactive"> <span class="dropdown-item list-group">New User Request made by {{ $data_item['name'] }}&nbsp;&nbsp; <br><small
                                                                class="text-right text-mute">
                                                                {{ \Carbon\Carbon::parse($data_item['updated_at'])->diffForHumans() }}</small></span></a>
                                                @endforeach
                                            @endif
                                        @endif
                                        {{-- if its a Validated--}}
                                        @if ($notification->type == 'App\Notifications\Validated')
                                            @if (count(auth()->user()->unreadNotifications) == 0)
                                                <a href="#"> <span class="dropdown-item list-group text-mute">No New
                                                        Notifications</span></a>
                                            @else
                                                    <a href="/"> <span class="dropdown-item list-group">Your Account Has Been Validated You Can Begin Work &nbsp;&nbsp; <br><small
                                                                class="text-right text-mute">
                                                                {{ \Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}</small></span></a>
                                            @endif
                                        @endif



                                        {{-- if it is a new request for an account --}}
                                        @role('branchadmin')
                                        @if ($notification->type == 'App\Notifications\RequestNotification' || $notification->type == 'App\Notifications\NewRequestCNotification')
                                            @if (count(auth()->user()->unreadNotifications) == 0)
                                                <a href="#"> <span class="dropdown-item list-group text-mute">No New
                                                        Notifications</span></a>
                                            @else
                                                @foreach ($notification->data as $data_item)
                                                    <span class="dropdown-item list-group">New Request made by
                                                        {{ $data_item['accountname'] }} &nbsp;&nbsp; <br><small
                                                            class="text-right text-mute">
                                                            {{ \Carbon\Carbon::parse($data_item['updated_at'])->diffForHumans() }}</small>
                                                    </span>
                                                @endforeach
                                            @endif
                                        @endif

                                        @endrole


                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </li>
                <li class="nav-item btn-rotate dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink2" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <i class="nc-icon nc-settings-gear-65"></i>
                        <p>
                            <span class="d-lg-none d-md-block">{{ __('Account') }}</span>
                        </p>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink2">
                        <form class="dropdown-item" action="{{ route('logout') }}" id="formLogOut" method="POST"
                            style="display: none;">
                            @csrf
                        </form>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item"
                                onclick="document.getElementById('formLogOut').submit();">{{ __('Log out') }}</a>
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


        $('#read').click(function(e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


            $.ajax({
                url: '/read_ajax',
                type: "GET",
                dataType: 'json',
                success: function(data) {
                    $('#badge').hide();
                },

            })

        });

    </script>
@endpush
