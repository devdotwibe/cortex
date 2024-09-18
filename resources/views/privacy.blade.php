<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Privacy Policy</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <header>
        <h1>Privacy Policy</h1>
    </header>
    
    <main>
        <section>
            @if(!empty($privacy->description))

            {!! $privacy->description !!}
            @endif
            {{-- <h2>Introduction</h2>
            <p>Welcome to Cortex. This privacy policy explains how we collect, use, disclose, and safeguard your information when you visit our website. Please read this privacy policy carefully.</p> --}}
        </section>

       
    </main>

   
</body>
</html>
