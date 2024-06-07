@extends('layouts.auth')
@section('title', 'Register')
@section('content')
<section class="register-wrapp">
    <div class="container mt-5">
        <div class="row d-flex justify-content-center">
            <div class="col-md-6">
                <div class="card @error('register') register-error @enderror px-5 py-5">
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
                                    <span>Name</span> 
                                    <input autocomplete="off" name="name" type="text" placeholder="Enter your name or username" value="{{old('name')}}" class="form-control @error('name') is-invalid @enderror " >
                                    @error('name')
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                                <div class="forms-inputs mb-4"> 
                                    <span>Email</span> 
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
                                <div class="forms-inputs mb-4"> 
                                    <span>Confirm Password</span> 
                                    <input autocomplete="off" name="re_password" type="password" placeholder="Re-enter password" class="form-control @error('re_password') is-invalid @enderror " >
                                    @error('re_password')
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                                <div class="mb-3"> 
                                    <button type="submit" class="btn btn-dark w-100">Login</button> 
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
