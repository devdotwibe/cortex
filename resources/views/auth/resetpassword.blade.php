@extends('layouts.auth')
@section('title', 'Login')
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
                    @session('message')
                    <div class="alert alert-success">
                        {{ session('message') }}
                    </div>
                    @endsession

                    @session('success')
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endsession

                    @error('email')
                        <div class="alert alert-danger">
                            <span>{{ $message }}</span>
                        </div>
                    @endif

                    <form action="{{url()->current()}}" class="form" method="post">
                        @csrf 
                        <div class="form-group">
                            <div class="form-data">
                                
                                <div class="forms-inputs mb-4"> 
                                    <span>Password</span> 
                                    <input autocomplete="off" name="password" type="password" placeholder="Enter your password" class="form-control @error('password') is-invalid @enderror " >
                                  
                                </div>

                                <div class="forms-inputs mb-4"> 
                                    <span>Confirm Password</span> 
                                    <input autocomplete="off" name="re_password" type="password" placeholder="Enter your password" class="form-control @error('re_password') is-invalid @enderror " >
                                  
                                </div>

                                @error('credential')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror

                                @if(session('mail-error'))
                                    <div class="invalid-feedback">
                                        {{ session('mail-error') }}
                                    </div>
                                @endif

                                <div class="mb-3"> 
                                    <button type="submit" class="btn btn-dark w-100">Submit</button> 
                                </div>
                            </div>
                        </div>
                    </form>
                                
                </div>
            </div>
        </div>
    </div>
</section> 
@endsection
