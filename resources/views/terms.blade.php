<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terms and conditions</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <header>
        <h1>Terms and conditions</h1>
    </header>
    
    <main>
        <section>
            @if(!empty($TermsAndConditions->description))

            {!! $TermsAndConditions->description !!}
            @endif
           
        </section>

       
    </main>

   
</body>
</html>
