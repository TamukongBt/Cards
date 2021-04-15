<div class="sidebar" data-color="dark" data-active-color="#15224c">
    <div class="logo">
        <a href="/" class="simple-text  logo-normal">
            <div class="">
                <img src="{{ asset('img') }}/logo.jpg">
            </div>
        </a>
        <a href="/" class="simple-text text-center logo-normal">
            {{ __('Cards n Checks ') }}
        </a>
    </div>
    <div class="sidebar-wrapper">
        <ul class="nav">
            <li class="{{ $elementActive == 'dashboard' ? 'active' : '' }}">
                <a href="{{ route('page.index', 'dashboard') }}">
                    <i class="nc-icon nc-bank"></i>
                    <p>{{ __('Dashboard') }}</p>
                </a>
            </li>
            @hasanyrole('csa|branchadmin|cards')
            <li class="">
                <a style="padding: 0%; margin:12px;" >
                    <h6><p><small>REQUEST</small></p></h6>
                </a>
            </li>
              {{-- Card Request --}}



            <li class="">
                <a data-toggle="collapse" aria-expanded="true" href="#laravelExamples">
                    <p>
                        <i class="fa fa-credit-card" aria-hidden="true"></i>
                            {{ __('Card Request') }}
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse" id="laravelExamples">
                    <ul class="nav">
                        <li class="{{ $elementActive == 'cardpending' ? 'active' : '' }}">
                            <a href="{{ route('cardrequest.index','cardpending') }}">
                                <span class="sidebar-mini-icon">...</span>
                                <span class="sidebar-normal">{{ __('Pending Requests') }}</span>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav">
                        <li class="{{ $elementActive == 'cardreject' ? 'active' : '' }}">
                            <a href="{{ route('request.rejected') }}">
                                <i class="nc-icon nc-simple-remove sidebar-mini-icon" aria-hidden="true"></i>
                                <span class="sidebar-normal">{{ __('Rejected Requests') }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            {{-- Check Request --}}
            <li class="">
                <a data-toggle="collapse" aria-expanded="true" href="#check">
                    <p>
                        <i class="nc-icon nc-book-bookmark" aria-hidden="true"></i>
                            {{ __('Check Request') }}
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse " id="check">
                    <ul class="nav">
                        <li class="{{ $elementActive == 'check' ? 'active' : '' }}">
                            <a href="{{ route('checkrequest.index') }}">
                                <span class="sidebar-mini-icon">...</span>
                                <span class="sidebar-normal">{{ __('Pending Requests') }}</span>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav">
                        <li class="{{ $elementActive == 'check2' ? 'active' : '' }}">
                            <a href="{{ route('crequest.rejected') }}">
                                <i class="nc-icon nc-simple-remove sidebar-mini-icon" aria-hidden="true"></i>
                                <span class="sidebar-normal">{{ __('Rejected Requests') }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            @endhasanyrole

            @hasanyrole('cards')
            <li class="">
                <a style="padding: 0%; margin:12px;" >
                    <h6><p><small>PRODUCTION FILE</small></p></h6>
                </a>
            </li>
              {{-- Card Request --}}



            <li class="">

                <div class="" >
                    <ul class="nav">
                        <li class="{{ $elementActive == 'cardpending' ? 'active' : '' }}">
                            <a href="{{ route('cardrequest.sproduction') }}">
                                <i class="nc-icon nc-simple-remove sidebar-mini-icon" aria-hidden="true"></i>
                                <span class="sidebar-normal">{{ __('Card Subscriptions') }}</span>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav">
                        <li class="{{ $elementActive == 'cardreject' ? 'active' : '' }}">
                            <a href="{{ route('cardrequest.rproduction') }}">
                                <i class="nc-icon nc-simple-remove sidebar-mini-icon" aria-hidden="true"></i>
                                <span class="sidebar-normal">{{ __('Card Renewals') }}</span>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav">
                        <li class="{{ $elementActive == 'cardreject' ? 'active' : '' }}">
                            <a href="{{ route('checkrequest.production') }}">
                                <i class="nc-icon nc-simple-remove sidebar-mini-icon" aria-hidden="true"></i>
                                <span class="sidebar-normal">{{ __('Check Production') }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            @endhasanyrole


            @hasanyrole('csa|branchadmin|cards')
            <li class="">
                <a style="padding: 0%; margin:12px;" >
                    <h6><p><small>DISTRIBUTION FILE</small></p></h6>
                </a>
            </li>

              {{-- distribution--}}
            <li class="{{ $elementActive == 'cardpending' || $elementActive == 'cardreject' ? 'active' : '' }}">

                <div class="" >
                    <ul class="nav">
                        <li class="{{ $elementActive == 'cardsubscribe' || $elementActive == 'cardreject' ? 'active' : '' }}">
                            <a data-toggle="collapse" aria-expanded="true" href="#laravelExampleqs">
                                <p>
                                    <i class="fa fa-credit-card" aria-hidden="true"></i>
                                    {{ __('Card Subscriptions') }}
                                    <b class="caret"></b>
                                </p>
                            </a>
                            <div class="collapse" id="laravelExampleqs">
                                <ul class="nav">
                                    <li class="{{ $elementActive == 'carddistribute' ? 'active' : '' }}">
                                        <a href="{{ route('cardrequest.sdistribution') }}">
                                            <span class="sidebar-mini-icon">...</span>
                                            <span class="sidebar-normal">{{ __('Pending Distribution') }}</span>
                                        </a>
                                    </li>
                                </ul>
                                <ul class="nav">
                                    <li class="{{ $elementActive == 'cardcollect' ? 'active' : '' }}">
                                        <a href="{{ route('cardrequest.scollected') }}">
                                            <i class="nc-icon nc-simple-remove sidebar-mini-icon" aria-hidden="true"></i>
                                            <span class="sidebar-normal">{{ __('Distrubuted Cards') }}</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                    </ul>
                    <ul class="nav">
                        <li class="{{ $elementActive == 'cardrenew' || $elementActive == 'cardreject' ? 'active' : '' }}">
                            <a data-toggle="collapse" aria-expanded="true" href="#laravelExampless">
                                <p>
                                    <i class="fa fa-credit-card" aria-hidden="true"></i>
                                    {{ __('Card Renewals') }}
                                    <b class="caret"></b>
                                </p>
                            </a>
                            <div class="collapse" id="laravelExampless">
                                <ul class="nav">
                                    <li class="{{ $elementActive == 'cardpending' ? 'active' : '' }}">
                                        <a href="{{ route('cardrequest.rdistribution') }}">
                                            <span class="sidebar-mini-icon">...</span>
                                            <span class="sidebar-normal">{{ __('Pending Distribution') }}</span>
                                        </a>
                                    </li>
                                </ul>
                                <ul class="nav">
                                    <li class="{{ $elementActive == 'cardreject' ? 'active' : '' }}">
                                        <a href="{{ route('cardrequest.rcollected') }}">
                                            <i class="nc-icon nc-simple-remove sidebar-mini-icon" aria-hidden="true"></i>
                                            <span class="sidebar-normal">{{ __('Distrubuted Cards') }}</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                    <ul class="nav">
                        <li class="{{ $elementActive == 'cardpending' || $elementActive == 'cardreject' ? 'active' : '' }}">
                            <a data-toggle="collapse" aria-expanded="true" href="#laravelExample">
                                <p>
                                    <i class="fa fa-credit-card" aria-hidden="true"></i>
                                    {{ __('Check Distribution') }}
                                    <b class="caret"></b>
                                </p>
                            </a>
                            <div class="collapse" id="laravelExample">
                                <ul class="nav">
                                    <li class="{{ $elementActive == 'cardpending' ? 'active' : '' }}">
                                        <a href="{{ route('checkrequest.distribution') }}">
                                            <span class="sidebar-mini-icon">...</span>
                                            <span class="sidebar-normal">{{ __('Pending Distribution') }}</span>
                                        </a>
                                    </li>
                                </ul>
                                <ul class="nav">
                                    <li class="{{ $elementActive == 'cardreject' ? 'active' : '' }}">
                                        <a href="{{ route('checkrequest.collected') }}">
                                            <i class="nc-icon nc-simple-remove sidebar-mini-icon" aria-hidden="true"></i>
                                            <span class="sidebar-normal">{{ __('Distrubuted Checks') }}</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </li>
            @endhasanyrole

            @role('dso')
            <li class="{{ $elementActive == 'icons' ? 'active' : '' }}">
                <a href="{{ route('transmissions.index') }}">
                    <i class="nc-icon nc-book-bookmark"></i>
                    <p>{{ __('Cards Available') }}</p>
                </a>
            </li>
            <li class="{{ $elementActive == 'icons' ? 'active' : '' }}">
                <a href="{{ route('cardrequest.index') }}">
                    <i class="fa fa-credit-card"></i>
                    <p>{{ __('Cards Requests') }}</p>
                </a>
            </li>
            <li class="{{ $elementActive == 'icons' ? 'active' : ''}}">
                <a href="{{ route('cardrequest.index') }}">
                    <i class="nc-icon nc-badge"></i>
                    <p>{{ __('Cards Renewals') }}</p>
                </a>
            </li>
            <li class="{{ $elementActive == 'user' ? 'active' : '' }}">
                <a href="{{ route('transmissions.pinindex') }}">
                    <i class="nc-icon nc-button-power " aria-hidden="true"></i>
                    <span class="sidebar-normal">{{ __('Cards without Pins') }}</span>
                </a>
            </li>
            <li class="{{ $elementActive == 'user' ? 'active' : '' }}">
                <a href="{{ route('transmissions.collectedpin') }}">
                    <i class="nc-icon nc-user-run sidebar-mini-icon" aria-hidden="true"></i>
                    <span class="sidebar-normal">{{ __('Cards with pins') }}</span>
                </a>
            </li>

            @endrole
            @role('cards')
            <li class="">
                <li class="">
                    <a style="padding: 0%; margin:12px;" >
                        <h6><p><small>OTHERS</small></p></h6>
                    </a>
                </li>

                <div class="" id="check">
                    <ul class="nav">
                        <li class="">
                            <a href="{{ route('cards.index') }}">
                                <i class="nc-icon nc-simple-remove sidebar-mini-icon" aria-hidden="true"></i>
                                <span class="sidebar-normal">{{ __('Cards') }}</span>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav">
                        <li class="">
                            <a href="{{ route('branch.index') }}">
                                <i class="nc-icon nc-simple-remove sidebar-mini-icon" aria-hidden="true"></i>
                                <span class="sidebar-normal">{{ __('Branches') }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            @endrole


        </ul>
    </div>
</div>
