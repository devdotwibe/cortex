<?php

namespace App\Http\Controllers;

use App\Models\banner;
use App\Models\Feature;
use App\Models\User;
use App\Models\UserProgress;
use App\Support\Helpers\OptionHelper;
use App\Support\Plugin\Payment;
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
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class HomeController extends Controller
{
    use ResourceController;
    public function index(Request $request){

        $banner = banner::first();

        $feature = Feature::get();

        return view("welcome",compact('banner','feature'));
    }
    public function login(Request $request){
        if(Auth::check()){
            return redirect('/dashboard');
        }
        if(Auth::guard('admin')->check()){
            return redirect('/admin/dashboard');
        }
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
        $pro=UserProgress::where('name',"cortext-subscription-payment-email")->where('value',$user->email)->first();
        if(!empty($pro)){
            $refuser=User::find($pro->user_id);
            if($refuser->progress('cortext-subscription-payment')=='paid'&&$refuser->progress('cortext-subscription-payment-plan')=='combo'){
                $user->setProgress('cortext-subscription-payment-ref',$refuser->progress('cortext-subscription-payment-transation'));
                $user->setProgress('cortext-subscription-payment','paid');
                $user->setProgress('cortext-subscription-payment-year',$refuser->progress('cortext-subscription-payment-year'));
            }
        }
        return redirect()->route('login')->with('success', " Account created Succesfully");
    }
    public function verifyemail($id,$hash){
        $user=User::find($id);
        if($hash==sha1($user->email)&&!$user->hasVerifiedEmail()){
            $user->markEmailAsVerified();
            event(new Verified($user));
            return redirect()->route('login')->with('success', " Account verifyed Succesfully");
        }else{
            return redirect()->route('login')->with('error', " Account Not verifyed");
        }
    }
    public function verificationnotice()
    {
        return view('auth.verify-email');
    }
    public function verificationresend(Request $request){
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('dashboard');
        }
        $request->user()->sendEmailVerificationNotification();
        return back()->with('resent', true);
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

    public function pricing(Request $request){
        return view('pricing.index');
    }
    public function verifypricing(Request $request){
        $request->validate([
            "year"=>['required'],
            "plan"=>['required'],
            "email"=>["required_if:plan,combo"]
        ]);
        $ajaxres=[];
        /**
        * @var User
        */
        $user=Auth::user();
        $email=$request->input('email','');
        if($request->plan=="combo"){ 
            if($user->email==$email){
                return throw ValidationException::withMessages(['email'=>["This email is not allowed. Please check the email address and try again."]]);
            }
            if(User::where('email',$email)->where('id','!=',$user->id)->count()>0){ 
                $ajaxres["success"]="verifyed";
            }else{
                $ajaxres["success"]="un-verifyed";
            }
        }
        if($request->ajax()){
            return response()->json($ajaxres);
        }
 
        try {  
            $payment =Payment::stripe()->paymentLinks->create([
                'line_items' => [
                [
                    'price' =>$request->plan=="combo"? OptionHelper::getData('stripe.subscription.payment.combo-amount',''): OptionHelper::getData('stripe.subscription.payment.amount',''),
                    'quantity' => 1,
                ],
                ], 
                'after_completion' => [
                    'type' => 'redirect',
                    'redirect' => ['url' => url("stripe/subscription/{$user->slug}/".'payment/{CHECKOUT_SESSION_ID}')],
                ],
            ]);
            $user->setProgress('cortext-subscription-payment-id',$payment->id);
            $user->setProgress('cortext-subscription-payment','pending');
            $user->setProgress('cortext-subscription-payment-plan',$request->plan);
            $user->setProgress('cortext-subscription-payment-email',$request->email);
            $user->setProgress('cortext-subscription-payment-year',$request->year);
            return redirect($payment->url);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error',$th->getMessage());
        }
    }
}
