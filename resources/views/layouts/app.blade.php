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
    
    <meta name="title" content="Cortex Online: Selective Test Preparation - Thinking Skills">
    <meta name="keywords" content="Cortex Online">
    <meta name="description" content="Australia's most successful Thinking Skills platform. Sign up for a free exam and start training for the NSW Selective School Test today!">

    <link rel="shortcut icon" href="{{ asset("assets/images/favicon.png") }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/slick-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/slider.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/stylesheet.css') }}">

    <!-- Start of Async ProveSource Code --><script>!function(o,i){window.provesrc&&window.console&&console.error&&console.error("ProveSource is included twice in this page."),window.provesrc={dq:[],display:function(){this.dq.push(arguments)}},o._provesrcAsyncInit=function(){window.provesrc.init({apiKey:"eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJhY2NvdW50SWQiOiI2MzhlYWU1MDgxZGUxYjA5Njk4NWFmYTAiLCJpYXQiOjE2NzAyOTUxMjF9.aZ1VQEcbSSjxzCyelsB2PWAJ07_ibpah3ifNl66wUdI",v:"0.0.4"})};var r=i.createElement("script");r.type="text/javascript",r.async=!0,r["ch"+"ar"+"set"]="UTF-8",r.src="https://cdn.provesrc.com/provesrc.js";var e=i.getElementsByTagName("script")[0];e.parentNode.insertBefore(r,e)}(window,document);</script><!-- End of Async ProveSource Code -->

</head>

<body>
    <div class="loading-wrap" style="display: none">
        <div class="loading-container">
            <div class="loading-image"><img src="{{ asset('assets/images/loader.svg') }}" alt=""></div>
            <span>Please wait...</span>
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

    <div class="sticky-box">
        <p>
            New: Cortex Online is updated to simulate the latest Online Selective Test &nbsp; &nbsp; 
            <a class="take-test" href="{{route('full-mock-exam.index')}}"> Take a free diagnostic test &#x2192; </a>
        </p>

    </div>

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

                         <h3>Need Support?</h3>
                        <ul>
                            <li>Contact <a href="mailto:support@cortexonline.com.au">support@cortexonline.com.au</a></li>
                        </ul> 
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
                        
                        <p><a href=""> Farnell Avenue
                                {{-- <span>Australia</span>  --}}
                            </a>
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

        $(function() {
            
            var stickyBox = $('.sticky-box'); 
            
            $(window).scroll(function() {

                if ($(this).scrollTop() > 3) {
                    
                    stickyBox.addClass('fixed');
                } else {
                 
                    stickyBox.removeClass('fixed');
                }
            });
        });

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
