<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="X-UA-Compatible" content="ie=edge"> 
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>
        @hasSection('title')
            @yield('title') |
        @endif {{ config('app.name') }}
    </title>


    @stack('meta')

    <link rel="shortcut icon" href="{{ asset("assets/images/favicon.png") }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset("assets/css/datatables.min.css") }}" > 

    @stack('style')

    <script src="{{ asset('assets/js/jquery-3.7.0.min.js') }}"></script> 
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script> 

    @stack('header-script')

</head>

<body>
    <div class="loading-wrap" style="display: none">
        <div class="loading-container">
            <div class="loading-image"><img src="{{asset('assets/images/loader.svg')}}" alt=""></div>
            <span>Plese wait...</span>
        </div>            
    </div>
    <nav class="navbar navbar-expand" >
        <div class="container"> 
            <a class="navbar-brand"  href="{{ url('/') }}">
                <img src="{{ asset('assets/images/cortexlogo.svg') }}" alt="">
            </a>    
            <ul class="navbar-nav ml-auto">
                {{-- <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarNotification" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-bell"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarNotification">
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                </li> --}}
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarLogin" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span>{{auth('web')->user()->name}}</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarLogin">
                        <a class="dropdown-item" href="{{ route('profile.view') }}">Profile</a>
                        <a class="dropdown-item" href="#">Settings</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{route('logout')}}">Log Out </a>
                    </div>
                </li>
            </ul>   
        </div>
    </nav>  
    @yield('content') 

    <x-toast-container />
    <x-confirm-popup />

    @stack('modals')

    @stack('before-script')
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
    <script src="{{ asset('assets/js/datatables.min.js') }}"></script> 
    <script src="{{ asset('assets/js/custom.js') }}"></script>
    @stack('footer-script')
</body>

</html>
