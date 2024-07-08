<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\Helpers\OptionHelper;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;

use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class MainController extends Controller
{
    public function index(Request $request){
        return view("admin.dashboard");
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
    public function logout(Request $request){
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }

    public function uploadstatus(Request $request,$tag){ 
        // return response()->stream(function()use($tag) {
        //     while (OptionHelper::getData("$tag","")!="") { 
        //         echo "data: " . json_encode([
        //             'status'=>OptionHelper::getData("$tag-status","complete"),
        //             'completed'=>OptionHelper::getData("$tag-completed","100"),
        //             'import'=>OptionHelper::getData("$tag",""),
        //         ]) . "\n\n";
        //         ob_flush();
        //         flush();
        //         sleep(1);
        //     }
        // }, 200, [
        //     'Content-Type' => 'text/event-stream',
        //     'Cache-Control' => 'no-cache',
        //     'Connection' => 'keep-alive',
        // ]); 
        return response()->json([
            'status'=>OptionHelper::getData("$tag-status")??"complete",
            'completed'=>OptionHelper::getData("$tag-completed")??"100",
            'import'=>OptionHelper::getData("$tag")??"",
        ]);
    } 
    public function uploadcancel(Request $request,$tag){ 
        OptionHelper::setData("$tag","stop"); 
        return redirect()->back()->with('success','Import Cancelled');
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
