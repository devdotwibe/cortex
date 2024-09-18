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
Regards,<br />

Cortex


@endsection
