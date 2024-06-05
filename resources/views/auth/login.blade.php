@extends('layouts.auth')
@section('title',"Login")
@section('content')
<section class="header_nav">           
    <div class="header_wrapp">
        <div class="header_title">
            <h2>Login</h2>
        </div>
        <div class="header_right">
            <ul class="nav_bar">
                <li class="nav_item"><a href="" class="nav_link btn">Demo</a></li>
            </ul>
        </div>
    </div>
</section>
<section class="container">
    <div class="row">
        <div class="col-md-12">
             <div class="login-wrap">
                <div class="form">
                    <form action="{{route('login')}}" method="POST" >
                        @csrf
                        <div class="form-group">
                            <label for=""></label>
                        </div>
                    </form>
                </div>
             </div>
        </div>
    </div>
</section>
@endsection