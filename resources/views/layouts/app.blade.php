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
                        <li class="nav-link"><a href="">Home</a></li>
                        <li class="nav-link"><a href="">Course</a></li>
                        <li class="nav-link"><a href="">Pricing</a></li>
                        <li class="nav-link"><a href="">Find a Tutor</a></li>
                        <li class="nav-link signup-link"><a href="">Sign Up</a></li>
                    </ul>
                    <div class="header-btn">
                        <a href="" class="header-btn1">Login</a>
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

    @stack('scripts')

</body>
</html>
