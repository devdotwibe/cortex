@extends('layouts.auth')
@section('title', 'Register')
@section('content')
<section class="login-wrapp register-wrapp">
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
                <img src="{{asset('assets/images/studying.png')}}" alt="">
            </div>
            <div class="login-right">
                <div class="card @error('register') register-error @enderror">
                    @error('register')
                    <div class="alert alert-danger" role="alert">
                        <span>{{$message}}</span>
                    </div>
                    @enderror
                    <form action="{{url()->current()}}" class="form" method="post">
                        @csrf
                        <div class="form-group">
                            <div class="form-data">
                                <div class="forms-inputs mb-4">
                                    <input autocomplete="off" name="first_name" type="text" placeholder="Enter your first name" value="{{old('first_name')}}" class="form-control @error('first_name') is-invalid @enderror " >
                                    @error('first_name')
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>

                                <div class="forms-inputs mb-4">
                                    <input autocomplete="off" name="last_name" type="text" placeholder="Enter your last name" value="{{old('last_name')}}" class="form-control @error('last_name') is-invalid @enderror " >
                                    @error('last_name')
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>

                                <div class="forms-inputs mb-4">
                                    <input autocomplete="off" name="email" type="text" placeholder="Enter your email or username" value="{{old('email')}}" class="form-control @error('email') is-invalid @enderror " >
                                    @error('email')
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>

                                <div class="forms-inputs mb-4">
                                    <input autocomplete="off" name="schooling_year" type="text" placeholder="Enter your Current Grade" value="{{old('schooling_year')}}" class="form-control @error('schooling_year') is-invalid @enderror " >
                                    @error('schooling_year')
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>

                                <div class="forms-inputs mb-4">
                                    <input autocomplete="off" name="password" type="password" placeholder="Enter your password" class="form-control @error('password') is-invalid @enderror " >
                                    @error('password')
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                                <div class="forms-inputs mb-4">
                                    <input autocomplete="off" name="re_password" type="password" placeholder="Re-enter password" class="form-control @error('re_password') is-invalid @enderror " >
                                    @error('re_password')
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <button type="submit" class="btn btn-dark w-100">Register</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <p>Already registered? <a href="{{route("login")}}" >Login here</a></p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
