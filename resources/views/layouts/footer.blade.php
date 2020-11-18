<footer class="footer footer-black  footer-white ">
    <div class="container-fluid">
        <div class="row">
            <div class="credits ml-auto">
                <span class="copyright">
                    ©
                    <script>
                        document.write(new Date().getFullYear())
                    </script>{{ __(', made') }} </i>{{ __(' by ') }}<a class="@if(Auth::guest()) text-white @endif" href="https://www.facebook.com/adoniscreative.com" target="_blank">{{ __('Adonis Creative') }}</a>
                </span>
            </div>
        </div>
    </div>
</footer>
