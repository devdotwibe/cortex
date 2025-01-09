<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">

    <title>
        @hasSection('title') 
            @yield('title')
        @else
            {{ config('app.name') }}
        @endif
    </title>
    <link rel="shortcut icon" href="{{ asset("assets/images/favicon.png") }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/slick-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/slider.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/stylesheet.css') }}">


</head>

<body>
    <div class="loading-wrap" style="display: none">
        <div class="loading-container">
            <div class="loading-image"><img src="{{ asset('assets/images/loader.svg') }}" alt=""></div>
            <span>Plese wait...</span>
        </div>
    </div>
    <header class="header-wrapp">
        <div class="container">
            <div class="header-row">
                <div class="brand-logo">
                    <a href="{{ url('/') }}">
                        <img src="{{ asset('app/images/logo.svg') }}" alt="">
                    </a>
                </div>
                <div class="header-right">
                    <ul>
                        <li class="nav-link"><a href="{{ url('/') }}">Home</a></li>
                        <li class="nav-link"><a href="{{ route('course.index') }}">Course</a></li>
                        <li class="nav-link"><a href="{{ route('pricing.index') }}">Pricing</a></li>
                        <li class="nav-link"><a href="">Find a Tutor</a></li>






                        @if (session('is.logined.as') == 'user' && Auth::check())
                        <li class="nav-link dropdown">
                            <a href="#" class="nav-link dropdown-toggle" id="userDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{-- Welcome, {{ Auth::user()->name }} --}}
                                Welcome, {{ \Illuminate\Support\Str::before(Auth::user()->name, ' ') }}
                            </a>
                            <div class="dropdown-menu" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="{{ route('dashboard') }}">Dashboard</a>
                                <a class="dropdown-item" href="{{ route('logout') }}">Logout</a>
                            </div>
                        </li>
                    @elseif (session('is.logined.as') == 'admin')
                        <li class="nav-link dropdown">
                            <a href="#" class="nav-link dropdown-toggle" id="adminDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Admin
                            </a>
                            <div class="dropdown-menu" aria-labelledby="adminDropdown">
                                <a class="dropdown-item" href="{{ route('admin.dashboard') }}">Dashboard</a>
                                <a class="dropdown-item" href="{{ route('admin.logout') }}">Logout</a>
                            </div>
                        </li>
                    @else
                        <li class="nav-link signup-link"><a href="{{ route('register') }}">Sign Up</a></li>
                        <div class="header-btn">
                            <a href="{{ route('login') }}" class="header-btn1">Login</a>
                        </div>
                    @endif
                    








                    </ul>

                </div>


                <div class="header-right mob">

                    <div class="hamburger-icon" onclick="toggleMenu()">
                        <span></span>
                    </div>
                    <div class="menu" id="menu">
                        <ul>

                            <li class="nav-link"><a href="{{ url('/') }}">Home</a></li>
                            <li class="nav-link"><a href="{{ route('course.index') }}">Course</a></li>
                            <li class="nav-link"><a href="{{ route('pricing.index') }}">Pricing</a></li>

                            <li class="nav-link"><a href="">Find a Tutor</a></li>

                            @if (session('is.logined.as') == 'user' && Auth::check())

                                    <li class="nav-link dropdown">
                                        <a href="#" class="nav-link dropdown-toggle" id="userDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            {{-- Welcome, {{ Auth::user()->name }} --}}
                                            Welcome, {{ \Illuminate\Support\Str::before(Auth::user()->name, ' ') }}
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="userDropdown">
                                            <a class="dropdown-item" href="{{ route('dashboard') }}">Dashboard</a>
                                            <a class="dropdown-item" href="{{ route('logout') }}">Logout</a>
                                        </div>
                                    </li>
                                @elseif (session('is.logined.as') == 'admin')
                                    <li class="nav-link dropdown">
                                        <a href="#" class="nav-link dropdown-toggle" id="adminDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Admin
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="adminDropdown">
                                            <a class="dropdown-item" href="{{ route('admin.dashboard') }}">Dashboard</a>
                                            <a class="dropdown-item" href="{{ route('admin.logout') }}">Logout</a>
                                        </div>
                                    </li>
                                @else
                                    <li class="nav-link signup-link"><a href="{{ route('register') }}">Sign Up</a></li>
                                    <div class="header-btn">
                                        <a href="{{ route('login') }}" class="header-btn1">Login</a>
                                    </div>
                            @endif


                        </ul>
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
                            <img src="{{asset('assets/images/footer-logo.svg')}}" alt="">
                        </a>
                        <div class="footer-buttons" >
                            <a href="{{ route('login') }}" class="btn btn-primary" style="margin-right: 10px;">Login</a>
                            <a href="{{ route('register') }}" class="btn btn-secondary">Sign Up</a>
                        </div>
                    </div>
                    <div class="footer-col2">
                        {{-- <h3>Courses</h3>
                        {{-- <ul>
                            <li><a href="">Diagnostic Exam</a></li>
                            <li><a href="">Critical Reasoning</a></li>
                            <li><a href="">Exam Preparation</a></li>
                        </ul> --}} 
                    </div>
                    <div class="footer-col3">
                        <h3>Information</h3>
                        <ul>
                            <li><a href="{{ url('/') }}">Home</a></li>
                            <li><a href="{{ route('pricing.index') }}">Pricing </a></li>
                            <li><a href="{{ route('course.index') }}">Course</a></li>
                            <li><a href="">Find Tutor</a></li>
                        </ul>
                    </div>
                    <div class="footer-col4">

                        <p><a href="https://www.cortexacademy.com.au" target="_blank">www.cortexacademy.com.au</a></p>
                        
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
        {{-- <div class="footer-row1">
            <div class="container">
                <p>Privacy Policy | Terms & Conditions © 2024 Cortex</p>
            </div>
        </div> --}}
        <div class="footer-row1">
            <div class="container">
                <p>
                    <a href="{{ route('privacy.index') }}">Privacy Policy</a> | 
                    <a href="{{ route('terms.index') }}">Terms & Conditions</a> 
                    © 2024 Cortex
                </p>
            </div>
        </div>

        
    </footer>

    @stack('modals')

    <script src="{{ asset('assets/js/jquery-3.7.0.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/slick.js') }}"></script>
    <script src="{{ asset('assets/js/active.js') }}"></script>
    <script src="{{ asset('assets/js/slider.js') }}"></script>
    <script src="{{ asset('assets/js/sticky-cards.js') }}"></script>
    <script src="{{ asset('assets/js/aos.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.js') }}"></script>
    


    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function(xhr) {
                $('.loading-wrap').show();
            },
            complete: function(xhr, status) {
                $('.loading-wrap').hide();
            },
        });

        function toggleMenu() {
            
            const menu = document.getElementById('menu');
            const hamburger = document.querySelector('.hamburger-icon');

            if (menu.style.display === 'flex') {
                menu.style.display = 'none';
            } else {
                menu.style.display = 'flex';
            }

            hamburger.classList.toggle('open');
        }

    </script>

    @stack('scripts')

</body>

</html>
