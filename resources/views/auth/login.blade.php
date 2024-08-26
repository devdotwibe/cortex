@extends('layouts.auth')
@section('title', 'Login')
@section('content')



<section class="login-wrapp">
    <div class="login-head">
        <div class="container">
            <div class="logo">
                <a href="">
                    <img src="{{asset('public/assets/images/logo1.svg')}}" alt="">
                </a>
            </div>
        </div>
    </div>
    <div class="login-cont">
        <div class="login-row">
            <div class="login-left">
                <img src="{{asset('public/assets/images/Book-lover-bro.png')}}" alt="">
            </div>
            <div class="login-right">
                <div class="card @error('login') login-error @enderror px-5 py-5">
                    @error('login')
                    <div class="alert alert-danger" role="alert">
                        <span>{{$message}}</span>
                    </div>
                    @enderror
                    @session('success')
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    @endsession

                    @session('status')
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                    @endsession

                    <form action="{{url()->current()}}" class="form" method="post">
                        @csrf 
                        <div class="form-group">
                            <div class="form-data">
                                <div class="forms-inputs mb-4"> 
                                    <span>Email or username</span> 
                                    <input autocomplete="off" name="email" type="text" placeholder="Enter your email or username" value="{{old('email')}}" class="form-control @error('email') is-invalid @enderror " >
                                    @error('email')
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                                <div class="forms-inputs mb-4"> 
                                    <span>Password</span> 
                                    <input autocomplete="off" name="password" type="password" placeholder="Enter your password" class="form-control @error('password') is-invalid @enderror " >
                                    @error('password')
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                                <div class="mb-3"> 
                                    <button type="submit" class="btn btn-dark w-100">Login</button> 
                                </div>
                            </div>
                        </div>
                    </form>
                    <p>Not registered? <a href="{{route("register")}}" >Register here</a>

                       
                    </p> 

                    <p>   
                        <a href="{{ route('password-reset') }}">Forgot your password?</a> 
                    </p>  

                </div>
            </div>
        </div>
    </div>
</section> 


@endsection
