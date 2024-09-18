@extends('layouts.email')
@section('content')

Dear {{$data['first_name']}},

Client want to contact you please see the details.
<br>
<p>

     First Name : {{$data['first_name']}}
    <br>
    Last Name :  {{$data['last_name']}}
    <br>
    Email :  {{$data['email']}}
    <br>
    Phone No :  {{$data['phone_number']}}
    <br>
    Message Details :  {{$data['message']}}
    <br>


</p>

<br>
Regards,<br />

Cortex


@endsection
