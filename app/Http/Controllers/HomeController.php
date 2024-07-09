<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Trait\ResourceController;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
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
            "first_name"=>["required",'string','min:3','max:250'],
            "last_name"=>["required",'string', 'max:250'],
            "email"=>["required",'email:rfc,dns','unique:users','unique:admins','max:250'],
            "schooling_year"=>["required",'string','max:250'],
            "password"=>["required",'string','min:6','max:250'],
            "re_password" => ["required","same:password"]
        ]);

        $userdata['name'] = $request->first_name . ' ' . $request->last_name;

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

    public function sendresetlink(Request $request){

        return view("auth.forgotpassword");
    }

    public function submitresetlink(Request $request){

        $request->validate(['email' => 'required|email']);
        if(!User::where('email', $request->email)->exists()){

            return redirect()->back()->with('mail-error','Given email does not exist');
        }

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
                    ? back()->with(['status' => __($status)])
                    : back()->withErrors(['email' => __($status)]);

    }

    public function resetpassword(Request $request,string $token){

        return view("auth.resetpassword", ['token' => $token,'email'=>$request->email]);
    }

    public function updatepassword(Request $request,$token){
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
                    ? redirect()->route('login')->with('status', __($status))
                    : back()->withErrors(['email' => [__($status)]]);

    }
}
