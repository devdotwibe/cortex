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

<div style="text-align: left;">
    <p>Problems or questions?</p>
    <p>support@cortexacademy.com.au</p>
    <p>Cortex Online . 7 Farnell Ave. Carlingford . Sydney. NSW. Australia</p>
</div>

Regards,<br />

The Cortex Online Team

<br />


@endsection
