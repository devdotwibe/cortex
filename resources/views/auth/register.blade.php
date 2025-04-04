@extends('layouts.auth')
@section('title', 'Register')
@section('content')
<section class="login-wrapp register-wrapp">
    <div class="login-head">
        <div class="logo">
            <a href="{{ url('/') }}">
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
                    <form action="{{url()->current()}}" id="register-form" class="form" method="post">
                        @csrf
                        <div class="form-group">
                            <div class="form-data">
                                <div class="forms-inputs mb-4">
                                    <input autocomplete="off" name="first_name" type="text" placeholder="Enter your first name" value="{{old('first_name')}}" class="form-control @error('first_name') is-invalid @enderror " >
                                    @error('first_name')
                                    <div id="first_name-error" class="error invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>

                                <div class="forms-inputs mb-4">
                                    <input autocomplete="off" name="last_name" type="text" placeholder="Enter your last name" value="{{old('last_name')}}" class="form-control @error('last_name') is-invalid @enderror " >
                                    @error('last_name')
                                    <div id="last_name-error" class="error invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>

                                <div class="forms-inputs mb-4">
                                    <input autocomplete="off" name="email" type="text" placeholder="Enter your email" value="{{old('email')}}" class="form-control @error('email') is-invalid @enderror " >
                                    @error('email')
                                    <div id="email-error" class="error invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>

                                <div class="forms-inputs mb-4">
                                    <input autocomplete="off" name="re_email" type="text" placeholder="Re-Enter your email" value="{{old('re_email')}}" class="form-control @error('re_email') is-invalid @enderror " >
                                    @error('re_email')
                                    <div id="re_email-error" class="error invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>

                                {{-- <div class="mb-4" style="font-size: smaller;" >Note: We are currently facing issues with Yahoo, Outlook and Hotmail. Gmail is the preferred email address.</div> --}}

                                <div class="forms-inputs mb-4">
                                    <input autocomplete="off" name="schooling_year" type="text" placeholder="Enter your Current Grade" value="{{old('schooling_year')}}" class="form-control @error('schooling_year') is-invalid @enderror " >
                                    @error('schooling_year')
                                    <div id="schooling_year-error" class="error invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>

                                <div class="forms-inputs mb-4">
                                    <input autocomplete="off" name="password" type="password" placeholder="Enter your password" class="form-control @error('password') is-invalid @enderror " >
                                    @error('password')
                                    <div id="password-error" class="error invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                                <div class="forms-inputs mb-4">
                                    <input autocomplete="off" name="re_password" type="password" placeholder="Re-enter password" class="form-control @error('re_password') is-invalid @enderror " >
                                    @error('re_password')
                                    <div id="re_password-error" class="error invalid-feedback">{{$message}}</div>
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

@push("footer-script")
<script>
    $( "#register-form" ).validate( {
	    rules: {
	        first_name: {
                required:true,
	            minlength: 3
            },
	        last_name: {
                required:true
            }, 
	        schooling_year: {
                required:true
            }, 
	        password: {
	            required: true,
	            minlength: 6
	        },
	        email: {
	            required: true,
	            email: true,
                // remote: {
                //     url: "check-email.php",  
                //     type: "post",
                //     data: {
                //         email: function() {
                //             return $(`[name="email"]`).val();
                //         } 
                //     }, 
                //     dataFilter: function(response) {
                //         var json = JSON.parse(response);
                //         if (json.valid) {
                //             return true;  
                //         } else {
                //             return json.message[];  
                //         }
                //     }
                // }
	        },
            re_email: {
                required: true,
                equalTo: '[name="email"]'  
            },
            re_password: {
                required: true,
                minlength: 6,
                equalTo: '[name="password"]'  
            },
	        // agree: "required"
	    },
	    messages: {
	        first_name: {
	            required: "Please enter your first name",
	            minlength: "Your first name must consist of at least 2 characters"
	        },
	        last_name: {
	            required: "Please enter your last name", 
	        },  
	        schooling_year: {
	            required: "Please enter your last name", 
	        },  
	        password: {
	            required: "Please provide a password",
	            minlength: "Your password must be at least 6 characters long"
	        },
            re_password: {
                required: "Please confirm your password",
                minlength: "Your password must be at least 6 characters long",
                equalTo: "Passwords do not match"   
            }, 
            re_email: {
                required: "Please confirm your Email",
                equalTo: "The re-enter email field must match the email address."   
            },  
	        email: {
	            required: "Please enter your email",
	            email: "Please enter a valid email address",
                // remote: "This email is already in use" 
	        }, 
	        // agree: "Please accept our policy"
	    },
	    errorElement: "div",
        validClass:"is-valid",
        errorClass:"is-invalid",
	    errorPlacement: function ( error, element ) { 
            if(element.next(error).length==0){
                error.insertAfter(element) 
            }
            element.next(error).addClass( "invalid-feedback" ); 
	    },
        // onkeyup: function(element) {
        //     $(element).valid();
        // },
        onchange: function(element) {
            $(element).valid();
        }
	});
</script>
@endpush
