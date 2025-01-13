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

Regards,<br />

The Cortex Online Team

<br />


@endsection
