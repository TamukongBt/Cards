<div class="wrapper">

    @include('layouts.navbars.auth')

    <div class="main-panel" style=" background-color: white;">
        @include('layouts.navbars.navs.auth')
        @yield('content')
        @include('layouts.footer')
    </div>
</div>
