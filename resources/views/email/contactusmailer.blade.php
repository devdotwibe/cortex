@extends('layouts.email')
@section('content')

Dear Admin,

<br>
<br>
Client want to contact you please see the details.
<br>
<p>

     First Name : {{$data['first_name']}}
    <br>
    Last Name :  {{$data['last_name']}}
    <br>
    Email :  {{$data['email']}}
    <br>
    Message Details :  {{$data['message']}}
    <br>


</p>

Regards,<br />

The Cortex Online Team

<br />


@endsection
