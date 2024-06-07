<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Trait\ResourceController;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class HomeController extends Controller
{
    use ResourceController; 
    public function index(Request $request){
        return view("welcome");
    }
    public function login(Request $request){
        return view("auth.login");
    }
    public function loginSubmit(Request $request){
        $credentials=$request->validate([
            "email"=>["required",'string'],
            "password"=>["required",'string'],
        ]);
        $this->ensureIsNotRateLimited($request);
        if (Auth::attempt($credentials))
        {
            RateLimiter::clear($this->throttleKey($request));
            $request->session()->regenerate();  
            return redirect()->intended('/dashboard');
        }
        if (Auth::guard('admin')->attempt($credentials))
        {
            RateLimiter::clear($this->throttleKey($request));
            $request->session()->regenerate();  
            return redirect()->intended('/admin/dashboard');
        }
        RateLimiter::hit($this->throttleKey($request));
        throw ValidationException::withMessages([
            'login' => 'The provided credentials do not match our records.',
        ]);
    }

    public function register(Request $request){
        return view("auth.register");
    }
    
    public function registerSubmit(Request $request){
        $userdata=$request->validate([
            "name"=>["required",'string','min:3','max:250'],
            "email"=>["required",'email:rfc,dns','unique:users','unique:admins','max:250'],
            "password"=>["required",'string','min:6','max:250'],
            "re_password" => ["required","same:password"]
        ]);
        $user=User::store($userdata);
        event(new Registered($user));
        return redirect()->route('login')->with('success', " Account created Succesfully");
    }
    public function verifyemail($id,$hash){
        $user=User::find($id);
        if($hash==sha1($user->email)&&!$user->hasVerifiedEmail()){
            $user->markEmailAsVerified(); 
            event(new Verified($user));
        }
    }
    





    public function ensureIsNotRateLimited(Request $request)
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey($request), 5)) {
            return;
        }
        event(new Lockout($request));
        $seconds = RateLimiter::availableIn($this->throttleKey($request));
        throw ValidationException::withMessages([
            'login' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }


    public function throttleKey(Request $request)
    {
        return Str::lower($request->input('email')) . '|' . $request->ip();
    }
}
