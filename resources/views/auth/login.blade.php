@extends('layouts.auth')
@section('title', 'Login')
@section('content')



<section class="login-wrapp">
    <div class="login-head">
        <div class="logo">
            <a href="">
                <img src="{{asset('assets/images/logo1.svg')}}" alt="">
            </a>
        </div>
    </div>
    <div class="login-cont">
        <div class="login-row">
            <div class="login-left">
                <img src="{{asset('assets/images/Book-lover-bro.png')}}" alt="">
            </div>
            <div class="login-right">
                <div class="card @error('login') login-error @enderror">
                    <h2>Welcome to Cortex</h2>
                    <h3>Login</h3>
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
                                    <input autocomplete="off" name="email" type="text" placeholder="Enter your email or username" value="{{old('email')}}" class="form-control @error('email') is-invalid @enderror " >
                                    @error('email')
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                                <div class="forms-inputs mb-4"> 
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
