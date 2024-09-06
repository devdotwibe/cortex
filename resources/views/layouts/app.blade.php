<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">

    <title> @hasSection ('title') @yield('title') @else {{config('app.name')}} @endif </title>

    <link rel="stylesheet" href="{{ asset('app/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('app/css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('app/css/slick-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('app/css/stylesheet.css') }}">
    <link rel="stylesheet" href="{{ asset('app/css/course.css') }}">

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

    <footer>
        <div class="footer-wrapp">
            <div class="container">
                <div class="footer-row">
                    <div class="footer-col1">
                        <a href="" class="footer-brand">
                            <img src="./assets/images/footer-logo.svg" alt="">
                        </a>
                    </div>
                    <div class="footer-col2">
                        <h3>Courses</h3>
                        <ul>
                            <li><a href="">Diagnostic Exam</a></li>
                            <li><a href="">Critical Reasoning</a></li>
                            <li><a href="">Exam Preparation</a></li>
                        </ul>
                    </div>
                    <div class="footer-col3">
                        <h3>Information</h3>
                        <ul>
                            <li><a href="">Home</a></li>
                            <li><a href="">Pricing </a></li>
                            <li><a href="">Courses</a></li>
                            <li><a href="">Find Tutor</a></li>
                        </ul>
                    </div>
                    <div class="footer-col4">
                        <p><a href="">www.cortexacademy.com.au</a></p>
                        <p><a href="">St Hudson Street
                            <span>Australia</span></a>
                        </p>
                        <p><a href="">Open 9am to 5pm
                            <span>Monday to Friday</span></a>
                        </p>
                        <ul class="social-icons">
                            <li><a href=""><img src="./assets/images/fb.svg" alt=""></a></li>
                            <li><a href=""><img src="./assets/images/yt.svg" alt=""></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-row1">
            <div class="container">
                <p>Privacy Policy | Terms & Conditions © 2024 Cortex</p>
            </div>
        </div>
    </footer>

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
