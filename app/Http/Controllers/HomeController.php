<?php

namespace App\Http\Controllers;

use App\Models\banner;
use App\Models\CouponOffer;
use App\Models\Course;
use App\Models\Pricing;
use App\Models\Courses;
use App\Models\Feature;
use App\Models\OurProcess;
use App\Models\Feed;
use App\Models\SubscriptionPlan;
use App\Models\User;
use App\Models\FaqCategory;
use App\Models\UserProgress;
use App\Models\UserSubscription;
use App\Support\Helpers\OptionHelper;
use App\Support\Plugin\Payment;
use App\Trait\ResourceController;
use Carbon\Carbon;
use Exception;
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

        $courses = Course::first();

        $feed = Feed::get();

        $faq = FaqCategory::get();



        $ourprocess = OurProcess::get();

        if(Auth::guard('web')->check()){

            return redirect('/dashboard');
        }

        if(Auth::guard('admin')->check()){

		    return redirect('/dashboard');
		}
            
        return view("welcome",compact('banner','feature','courses','feed','faq','ourprocess'));

    }

    public function menustatus(Request $request)
    {

        $collapsed = $request->input('collapsed'); 
    
        Session::put('sidebarCollapsed',$collapsed);

        return response()->json([
            'status' => 'success',
            'collapsed' => $collapsed,
        ]);
    }

    public function login(Request $request){
        if(Auth::guard('web')->check()){

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

            session()->put('sidebarCollapsed','true');

            $remember = $request->has('remember'); 

            if (Auth::attempt([
                'email' => $request->email,
                'password' => $request->password
            ], $remember)) {
               
                return redirect()->intended('/dashboard');
            }

            return redirect()->intended('/dashboard');
        }
        if (Auth::guard('admin')->attempt($credentials))
        {
            RateLimiter::clear($this->throttleKey($request));
            $request->session()->regenerate();
            session()->put('sidebarCollapsed','true');

            $remember = $request->has('remember'); 

            if (Auth::guard('admin')->attempt([
                'email' => $request->email,
                'password' => $request->password
            ], $remember)) {
               
                return redirect()->intended('/dashboard');
            }

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
            "re_email" => ["required","same:re_email"],
            "schooling_year"=>["required",'string','max:250'],
            "password"=>["required",'string','min:6','max:250'],
            "re_password" => ["required","same:password"]
        ],
        [
            're_email.same' => 'The Re-enter email field must match the email address.',
            're_email.required' => 'The Re-enter email field is required.',
        ]);

        $userdata['name'] = $request->first_name . ' ' . $request->last_name;

        $user=User::store($userdata);
        event(new Registered($user));
        $subscribtion=UserSubscription::where("email",$user->email)->where('status','subscribed')->first();
        // $pro=UserProgress::where('name',"cortext-subscription-payment-email")->where('value',$user->email)->first();
        // if(!empty($pro)){
        //     $refuser=User::find($pro->user_id);
        //     if($refuser->progress('cortext-subscription-payment')=='paid'&&$refuser->progress('cortext-subscription-payment-plan')=='combo'){
        //         $user->setProgress('cortext-subscription-payment-ref',$refuser->progress('cortext-subscription-payment-transation'));
        //         $user->setProgress('cortext-subscription-payment','paid');
        //         $user->setProgress('cortext-subscription-payment-year',$refuser->progress('cortext-subscription-payment-year'));
        //     }
        // }
        if(!empty($subscribtion)){
            UserSubscription::store([
                'payment_id'=>$subscribtion->payment_id,
                'stripe_id' =>$subscribtion->stripe_id,
                'user_id'=>$user->id,
                'pay_by'=>$subscribtion->pay_by,
                'subscription_plan_id'=>$subscribtion->subscription_plan_id,
                'payment_status'=>'refered',
                'amount'=>$subscribtion->amount,
                'status'=>"subscribed",
                'expire_at'=>$subscribtion->expire_at,
            ]);
        }
        return redirect()->route('login')->with('success', " Account created Succesfully");
    }
    public function verifyemail($id,$hash){
        $user=User::findOrFail($id);
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
        return view('notice.verify-email');
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

            return redirect()->back()->with('mail-error','The provided credentials do not match our records.');
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
        $subscriptionPlans = SubscriptionPlan::where(function($qry){
            $qry->where(function($iqry){
                $iqry->where('is_external',true);
                $iqry->whereNull('end_plan');
            });
            $qry->orWhere(function($iqry){
                $iqry->whereNotNull('end_plan')->whereDate('end_plan','>=',Carbon::now()->toDateString());
            });
        })->get();
        
        
        $price = Pricing::first();
        return view("price",compact('subscriptionPlans','price'));
    }
    public function verifycoupon(Request $request){
        $request->validate([ 
            "coupon"=>['required'],
            "subscription"=>['required']
        ]);
        $coupon=trim($request->coupon);
        $subscriptionPlan=SubscriptionPlan::findSlug($request->subscription);
        if(CouponOffer::where('name',$coupon)->count()>0&&!empty($subscriptionPlan)){
            $offer=CouponOffer::where('name',$coupon)->first();
            $price=($request->type??"")=="combo"? floatval($subscriptionPlan->combo_amount??0)*2:floatval($subscriptionPlan->basic_amount??0);
            $offerprice=floatval($offer->amount);
            $newprice=$price-$offerprice;
            if($newprice<0){
                $newprice=0;
                $offerprice=$price;
            }
            return response()->json([
                "price"=>$price,
                "offer"=>$offerprice,
                "pay"=>$newprice,
                "message"=>"<p>
                                <strong>Coupon Applied Successfully!</strong><br>
                                <span>Congratulations! Your coupon has been applied, and you've saved \$$offerprice. Your total is \$$newprice.</span>
                            </p>"
            ]);
        }
        return throw ValidationException::withMessages(["coupon"=>["Invalid Coupon Code"]]);
    }
    public function combo_mail(Request $request){
        $request->validate([
            "email"=>['required','email'], 
        ]);
        $email=$request->input('email','');
        /**
        * @var User
        */
        $user=Auth::user();
        if($user->email==$email){
            return throw ValidationException::withMessages(['email'=>[" Entered mail id same as your, please try with another one."]]);
        }

        if(User::where('email',$email)->where('id','!=',$user->id)->count()>0){
            $tuser=User::where('email',$email)->first();
            if(!empty($tuser)&&(optional($tuser->subscription())->status??'')=="subscribed"){ 
                return throw ValidationException::withMessages(['email'=>["You inviting friend is already subscribed . Please confirm before payment"]]);
            }
           return response()->json([
             'message'=> "User Mail Approved "
           ]);
        }else{
            return response()->json([
                'message'=> "Not found a user with submitted mail id. No problem now you can subscribe with this mail id then later registering with this same mail id the user will get this subscription. "
            ]);
        }
    }
    public function getpricing(Request $request,SubscriptionPlan $subscriptionPlan){
        if($request->ajax()){
            return $subscriptionPlan;
        }
        return redirect()->back();
    }
    public function verifypricing(Request $request,SubscriptionPlan $subscriptionPlan){
        $request->validate([ 
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
                return throw ValidationException::withMessages(['email'=>[" Entered mail id same as your, please try with another one."]]);
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
            $coupon=trim($request->coupon??"");
            if(CouponOffer::where('name',$coupon)->count()>0){
                $offer=CouponOffer::where('name',$coupon)->first();
                $oldprice=($request->plan??"")=="combo"?floatval($subscriptionPlan->combo_amount??0)*2:floatval($subscriptionPlan->basic_amount??0);
                $oldkey=($request->type??"")=="combo"?$subscriptionPlan->combo_amount_id:$subscriptionPlan->basic_amount_id;
                $offerprice=floatval($offer->amount);
                $newprice=$oldprice-$offerprice;
                if($newprice<0){
                    $newprice=0;
                    $offerprice=$oldprice;
                }
                $price=Payment::stripe()->prices->create([
                    'currency' => config('stripe.currency'),
                    'unit_amount' => intval($newprice*100),
                    'product_data' => ['name' => ' Offer Amount :'.(intval($newprice*100)/100).' For '.($request->plan).' Plan'],
                    'metadata'=>[
                        'modify_time'=>date('Y-m-d h:i a'),
                        'original_key'=>$oldkey,
                        'original_value'=>$oldprice,
                    ]
                ]);
                $payment =Payment::stripe()->paymentLinks->create([
                    'line_items' => [
                        [
                            'price' =>$price->id,
                            'quantity' => 1,
                        ],
                    ],
                    'after_completion' => [
                        'type' => 'redirect',
                        'redirect' => ['url' => url("stripe/subscription/{$user->slug}/plan/{$subscriptionPlan->slug}/{$request->plan}/".'payment/{CHECKOUT_SESSION_ID}')],
                    ],
                ]);
                // $user->setProgress('cortext-subscription-payment-id',$payment->id);
                // $user->setProgress('cortext-subscription-payment','pending');
                // $user->setProgress('cortext-subscription-payment-plan',$request->plan);
                $user->setProgress('cortext-subscription-payment-email',$request->email);
                // $user->setProgress('cortext-subscription-payment-year',$request->year);
                $user->setProgress('cortext-subscription-payment-coupon',$coupon);
                return redirect($payment->url);
            }else{

                $payment =Payment::stripe()->paymentLinks->create([
                    'line_items' => [
                        [
                            'price' =>$request->plan=="combo"? $subscriptionPlan->combo_amount_id:  $subscriptionPlan->basic_amount_id,
                            'quantity' => 1,
                        ],
                    ],
                    'after_completion' => [
                        'type' => 'redirect',
                        'redirect' => ['url' => url("stripe/subscription/{$user->slug}/plan/{$subscriptionPlan->slug}/{$request->plan}/".'payment/{CHECKOUT_SESSION_ID}')],
                    ],
                ]);
                // $user->setProgress('cortext-subscription-payment-id',$payment->id);
                // $user->setProgress('cortext-subscription-payment','pending');
                // $user->setProgress('cortext-subscription-payment-plan',$request->plan);
                $user->setProgress('cortext-subscription-payment-email',$request->email);
                // $user->setProgress('cortext-subscription-payment-year',$request->year);
                return redirect($payment->url);
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('error',$th->getMessage());
        }
    }
    public function subscriptionnotice(Request $request,$payment_intent)
    {
        $payment=Payment::stripe()->paymentIntents->retrieve($payment_intent);
        return view('notice.subscription',compact('payment'));
    }
 
}
