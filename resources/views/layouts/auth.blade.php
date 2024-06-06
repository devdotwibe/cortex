<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
</body>
</html>