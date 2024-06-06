<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class HomeController extends Controller
{
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
        RateLimiter::hit($this->throttleKey($request));
        throw ValidationException::withMessages([
            'login' => 'The provided credentials do not match our records.',
        ]);
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
