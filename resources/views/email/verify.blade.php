@extends('layouts.email')
@section('content')

Dear {{ ucfirst($name) }},

<br>
<br>
Thank you for registering with our service. Please verify your email address by clicking the link below:

<br>
<p>
    <a href="{{ $url }}" style="color: #4CAF50; text-decoration: none;">
        Verify Your Email Address
    </a>
</p>

<div style="text-align: left;">
    <p>Problems or questions?</p>
    <p>support@cortexacademy.com.au</p>
    <p>Cortex Online . 7 Farnell Ave. Carlingford . Sydney. NSW. Australia</p>
</div>

Regards,<br />

The Cortex Online Team

<br />


@endsection
