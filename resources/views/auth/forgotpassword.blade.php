@extends('layouts.auth')
@section('title', 'Forgot Password')
@section('content')
<section class="login-wrapp">
    <div class="container mt-5">
        <div class="row d-flex justify-content-center">
            <div class="col-md-6">
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
                    @session('mail-error')
                    <div class="alert alert-success">
                        {{ session('mail-error') }}
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
                               
                                <div class="mb-3"> 
                                    <button type="submit" class="btn btn-dark w-100">Reset Password</button> 
                                </div>
                            </div>
                        </div>
                    </form>
                    <p>Click Here to <a href="{{route("login")}}" >Login</a> </p>    

                </div>
            </div>
        </div>
    </div>
</section> 
@endsection
