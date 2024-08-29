<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title> @hasSection ('title') @yield('title') @else {{config('app.name')}} @endif </title> 

    <link rel="stylesheet" href="{{ asset('app/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('app/css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('app/css/slick-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('app/css/stylesheet.css') }}">
 
</head>
<body>
    <div class="loading-wrap" style="display: none">
        <div class="loading-container">
            <div class="loading-image"><img src="{{asset('assets/images/loader.svg')}}" alt=""></div>
            <span>Plese wait...</span>
        </div>
    </div>
    <header class="header-wrapp">
        <div class="container">
            <div class="header-row">
                <div class="brand-logo">
                    <a href=""> 
                        <img src="{{ asset('app/images/logo.svg') }}" alt="">
                    </a>
                </div>
                <div class="header-right">
                    <ul>
                        <li class="nav-link"><a href="{{url('/')}}">Home</a></li>
                        <li class="nav-link"><a href="">Course</a></li>
                        <li class="nav-link"><a href="{{route('pricing.index')}}">Pricing</a></li>
                        <li class="nav-link"><a href="">Find a Tutor</a></li>
                        <li class="nav-link signup-link"><a href="{{route('register')}}">Sign Up</a></li>
                    </ul>
                    <div class="header-btn">
                        <a href="{{route('login')}}" class="header-btn1">Login</a>
                    </div>
                </div>
            </div>
        </div>
    </header>
    @yield('content')

    @stack('modals')

    <script src="{{ asset('app/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('app/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('app/js/slick.js') }}"></script>
    <script src="{{ asset('app/js/sticky-cards.js') }}"></script>
    <script src="{{ asset('app/js/scripts.js') }}"></script>
    <script>

        $.ajaxSetup({
             headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             },
             beforeSend:function(xhr){
                 $('.loading-wrap').show();
             },
             complete:function(xhr,status){
                 $('.loading-wrap').hide();
             },
        });
    </script>

    @stack('scripts')

</body>
</html>
