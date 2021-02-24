<div class="sidebar" data-color="dark" data-active-color="#15224c">
    <div class="logo">
        <a href="/" class="simple-text  logo-normal">
            <div class="">
                <img src="{{ asset('img') }}/logo.jpg">
            </div>
        </a>
        <a href="/" class="simple-text text-center logo-normal">
            {{ __('Cards n Cheques ') }}
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
            @role('css')
            <li class="{{ $elementActive == 'user' || $elementActive == 'profile' ? 'active' : '' }}">
                <a data-toggle="collapse" aria-expanded="true" href="#laravelExamples">
                    <p>
                        <i class="nc-icon nc-book-bookmark" aria-hidden="true"></i>
                            {{ __('Request') }}
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse show" id="laravelExamples">
                    <ul class="nav">
                        <li class="{{ $elementActive == 'profile' ? 'active' : '' }}">
                            <a href="{{ route('request.index') }}">
                                <span class="sidebar-mini-icon">...</span>
                                <span class="sidebar-normal">{{ __(' Pending Requests ') }}</span>
                            </a>
                        </li>
                        <li class="{{ $elementActive == 'user' ? 'active' : '' }}">
                            <a href="{{ route('request.approved') }}">
                                <i class="nc-icon nc-check-2 sidebar-mini-icon" aria-hidden="true"></i>
                                <span class="sidebar-normal">{{ __('Processed Requests') }}</span>
                            </a>
                        </li>
                        <li class="{{ $elementActive == 'user' ? 'active' : '' }}">
                            <a href="{{ route('request.rejected') }}">
                                <i class="nc-icon nc-simple-remove sidebar-mini-icon" aria-hidden="true"></i>
                                <span class="sidebar-normal">{{ __('Rejected Requests') }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            @endrole
            @role('csa')
            <li class="{{ $elementActive == 'user' || $elementActive == 'profile' ? 'active' : '' }}">
                <a data-toggle="collapse" aria-expanded="true" href="#laravelExamples">
                    <p>
                        <i class="nc-icon nc-book-bookmark" aria-hidden="true"></i>
                            {{ __('Request') }}
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse show" id="laravelExamples">
                    <ul class="nav">
                        <li class="{{ $elementActive == 'profile' ? 'active' : '' }}">
                            <a href="{{ route('request.index') }}">
                                <span class="sidebar-mini-icon">...</span>
                                <span class="sidebar-normal">{{ __(' Pending Requests ') }}</span>
                            </a>
                        </li>
                        <li class="{{ $elementActive == 'user' ? 'active' : '' }}">
                            <a href="{{ route('request.approves') }}">
                                <i class="nc-icon nc-check-2 sidebar-mini-icon" aria-hidden="true"></i>
                                <span class="sidebar-normal">{{ __('Approved Requests') }}</span>
                            </a>
                        </li>
                        <li class="{{ $elementActive == 'user' ? 'active' : '' }}">
                            <a href="{{ route('request.approved') }}">
                                <i class="nc-icon nc-simple-remove sidebar-mini-icon" aria-hidden="true"></i>
                                <span class="sidebar-normal">{{ __('Processed Requests') }}</span>
                            </a>
                        </li>
                        <li class="{{ $elementActive == 'user' ? 'active' : '' }}">
                            <a href="{{ route('request.rejected') }}">
                                <i class="nc-icon nc-simple-remove sidebar-mini-icon" aria-hidden="true"></i>
                                <span class="sidebar-normal">{{ __('Rejected Requests') }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            @endrole
            @role('cards')
            <li class="{{ $elementActive == 'user' || $elementActive == 'profile' ? 'active' : '' }}">
                <a data-toggle="collapse" aria-expanded="true" href="#laravelExamples">
                    <p>
                        <i class="nc-icon nc-book-bookmark" aria-hidden="true"></i>
                            {{ __('Request') }}
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse show" id="laravelExamples">
                    <ul class="nav">
                        <li class="{{ $elementActive == 'user' ? 'active' : '' }}">
                            <a href="{{ route('request.index') }}">
                                <span class="sidebar-mini-icon">...</span>
                                <span class="sidebar-normal">{{ __('Pending Requests') }}</span>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav">
                        <li class="{{ $elementActive == 'user' ? 'active' : '' }}">
                            <a href="{{ route('request.approved') }}">
                                <i class="nc-icon nc-check-2 sidebar-mini-icon" aria-hidden="true"></i>
                                <span class="sidebar-normal">{{ __('Processed Requests') }}</span>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav">
                        <li class="{{ $elementActive == 'user' ? 'active' : '' }}">
                            <a href="{{ route('request.rejected') }}">
                                <i class="nc-icon nc-simple-remove sidebar-mini-icon" aria-hidden="true"></i>
                                <span class="sidebar-normal">{{ __('Rejected Requests') }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            @endrole
            @hasanyrole('csa|css|cards')
            <li class="{{ $elementActive == 'user' || $elementActive == 'profile' ? 'active' : '' }}">
                <a data-toggle="collapse" aria-expanded="true" href="#laravelExample">
                    <p>
                        <i class="nc-icon nc-book-bookmark" aria-hidden="true"></i>
                            {{ __('Transmissions') }}
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse show" id="laravelExample">
                    <ul class="nav">
                        <li class="{{ $elementActive == 'profile' ? 'active' : '' }}">
                            <a href="{{ route('transmissions.index') }}">
                                <span class="sidebar-mini-icon">...</span>
                                <span class="sidebar-normal">{{ __(' Pending Cards') }}</span>
                            </a>
                        </li>
                        <li class="{{ $elementActive == 'user' ? 'active' : '' }}">
                            <a href="{{ route('transmissions.collected') }}">
                                <i class="nc-icon nc-check-2 sidebar-mini-icon" aria-hidden="true"></i>
                                <span class="sidebar-normal">{{ __('Cards Collected') }}</span>
                            </a>
                        </li>

                        @hasanyrole('css|cards')
                        <li class="{{ $elementActive == 'user' ? 'active' : '' }}">
                            <a href="{{ route('transmissions.pinindex') }}">
                                <i class="nc-icon nc-button-power sidebar-mini-icon" aria-hidden="true"></i>
                                <span class="sidebar-normal">{{ __('Cards without Pins') }}</span>
                            </a>
                        </li>
                        <li class="{{ $elementActive == 'user' ? 'active' : '' }}">
                            <a href="{{ route('transmissions.collectedpin') }}">
                                <i class="nc-icon nc-user-run sidebar-mini-icon" aria-hidden="true"></i>
                                <span class="sidebar-normal">{{ __('Cards with pins') }}</span>
                            </a>
                        </li>
                        @endhasanyrole
                        <li class="{{ $elementActive == 'user' ? 'active' : '' }}">
                            <a href="{{ route('cheque.index') }}">
                                <span class="sidebar-mini-icon">...</span>
                                <span class="sidebar-normal">{{ __('Pending Cheques') }}</span>
                            </a>
                        </li>
                        <li class="{{ $elementActive == 'user' ? 'active' : '' }}">
                            <a href="{{ route('cheque.collected') }}">
                                <i class="nc-icon nc-check-2 sidebar-mini-icon" aria-hidden="true"></i>
                                <span class="sidebar-normal">{{ __('Cheques Collected') }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="{{ $elementActive == 'dashboard' ? 'active' : '' }}">
                <a href="{{ route('request.approved') }}">
                    <i class="nc-icon nc-check-2"></i>
                    <p>{{ __('Approved request') }}</p>
                </a>
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
                <a href="{{ route('request.index') }}">
                    <i class="fa fa-credit-card"></i>
                    <p>{{ __('Cards Requests') }}</p>
                </a>
            </li>
            <li class="{{ $elementActive == 'icons' ? 'active' : ''}}">
                <a href="{{ route('request.index') }}">
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
            @hasanyrole('cards|it')
            <li >
                <a href="{{ route('batch.index') }}">
                    <i class="nc-icon nc-box"></i>
                    <p>{{ __('Batch Request') }}</p>
                </a>
            </li>
            @endhasanyrole
            @role('cards')
            <li class="{{ $elementActive == 'icons' ? 'active' : '' }}">
                <a href="{{ route('cards.index') }}">
                    <i class="fa fa-credit-card" aria-hidden="true"></i>
                    <p>{{ __('Cards') }}</p>
                </a>
            </li>
            @endrole
            @role('cards')
            <li class="{{ $elementActive == 'notifications' ? 'active' : '' }}">
                <a href="{{ route('branch.index') }}">
                    <i class="nc-icon nc-pin-3"></i>
                    <p>{{ __('Branches') }}</p>
                </a>
            </li>
            @endrole
            @role('it')
            <li class="{{ $elementActive == 'slots' ? 'active' : '' }}">
                <a href="{{ route('slots.index','slots') }}">
                    <i class="nc-icon nc-tile-56"></i>
                    <p>{{ __('Card Slots') }}</p>
                </a>
            </li>
            @elserole('cards')
            <li class="{{ $elementActive == 'slots' ? 'active' : '' }}">
                <a href="{{ route('slots.create') }}">
                    <i class="nc-icon nc-tile-56"></i>
                    <p>{{ __('Card Slots') }}</p>
                </a>
            </li>
            @endhasanyrole

        </ul>
    </div>
</div>
