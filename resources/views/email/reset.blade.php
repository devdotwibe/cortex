@extends('layouts.email')
@section('content')

Dear {{ $name }},



We received a request to reset your password. You can reset it by clicking the link below:

<br>
<p>
    <a href="{{ $url }}" style="color: #4CAF50; text-decoration: none;">
        Reset Your Password
    </a>
</p>
<br>
<br>

<p> Problems or question ? </p>
<br>
<p>  support@cortexacademy.com.au</p>
<br>
<p>Cortex Online . 7 Farnell Ave. Carlingford . Sydney. NSW. Australia</p>



@endsection
