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
        @hasSection('title') @yield('title') | @endif   {{config('app.name')}}
    </title>
    <link rel="stylesheet" href="{{asset("assets/css/bootstrap.min.css")}}"> 
    <link rel="stylesheet" href="{{asset("assets/css/style.css")}}"> 
</head>
<body > 
    <main class="content_outer">
        @yield('content')
    </main>


    <script src="{{asset("assets/js/bootstrap.min.js")}}"></script>
    <script src="{{asset("assets/js/jquery-3.7.0.min.js")}}"></script>
    <script src="{{asset("assets/js/popper.min.js")}}"></script> 
    <script src="{{asset("assets/js/jquery.validate.min.js")}}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')  // Fetch the CSRF token
            }
        });

    </script>

    @stack('footer-script')
</body>
</html>