<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\PaymentTransation;
use App\Models\SubscriptionPlan;
use App\Models\User;
use App\Models\UserSubscription;
use App\Support\Helpers\OptionHelper;
use App\Support\Plugin\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 

class StripePaymentController extends Controller
{
    public function workshop(Request $request){
        /**
         * @var User
         */
        $user=Auth::user();
        // $customerId=null;
        // if(!empty($user->stripe_id)){
        //     try {
        //       $customer= Payment::stripe()->customers->retrieve($user->stripe_id);
        //       $customerId=$customer->id;
        //     } 
        //     catch (\Throwable $th) {
        //         //throw $th;
        //     }
        // }
        // if(empty($customerId)){
        //     try {
        //         $customer= Payment::stripe()->customers->create([
        //             'name'=>$user->name,
        //             'email'=>$user->email,
        //         ]);
        //         $user->stripe_id=$customer->id;
        //         $user->save();
        //     } 
        //     catch (\Throwable $th) {
        //         return redirect()->back()->with('error',$th->getMessage());
        //     }
        // }
        try {  
            $payment =Payment::stripe()->paymentLinks->create([
                'line_items' => [
                [
                    'price' => OptionHelper::getData('stripe.workshop.payment.amount',''),
                    'quantity' => 1,
                ],
                ], 
                'after_completion' => [
                    'type' => 'redirect',
                    'redirect' => ['url' => url("stripe/workshop/{$user->slug}/".'payment/{CHECKOUT_SESSION_ID}')],
                ],
            ]);
            $user->setProgress('intensive-workshop-payment-id',$payment->id);
            $user->setProgress('intensive-workshop-payment','pending');
            return redirect($payment->url);
        } catch (\Throwable $th) {
            // return redirect()->back()->with('error','Coming soon');
            return redirect()->back()->with('error',$th->getMessage());
        }
    }
    public function workshop_payment(Request $request,User $user,$payment){
        $payment=Payment::stripe()->checkout->sessions->retrieve($payment); 
        $user->setProgress('intensive-workshop-payment-session',$payment->id); 
        $user->setProgress('intensive-workshop-payment-transation',$payment->payment_intent);  
        if($payment->payment_status=="paid"){
            $user->setProgress('intensive-workshop-payment','paid');
            $intent=Payment::stripe()->paymentIntents->retrieve($payment->payment_intent);

            $transation=new PaymentTransation;
            $transation->stype='workshop';
            $transation->user_id=$user->id;
            $transation->slug=$payment->payment_intent; 
            $transation->amount=$intent->amount/100; 
            $transation->status="paid";
            $transation->content="Workshop payment \n Amount : ".($intent->amount/100)." \n Amount Recive: ".($intent->amount_received/100)."  ";
            $transation->save();
            return redirect()->route('live-class.workshop.form',$user->slug)->with('success',"Workshop payment has success");
        }else{
            $transation=new PaymentTransation;
            $transation->stype='workshop';
            $transation->user_id=$user->id;
            $transation->slug=$payment->payment_intent??$payment->id;
            $transation->save();
            if($payment->status=="open"){
                return redirect()->route('live-class.workshop',$user->slug)->with('error',"Workshop payment in-complete");
            }else{
                return redirect()->route('live-class.workshop',$user->slug)->with('error',"Workshop payment Failed");
            }
        }

    }

    public function subscription(Request $request){
        /**
         * @var User
         */
        $user=Auth::user(); 
        try {  
            $payment =Payment::stripe()->paymentLinks->create([
                'line_items' => [
                [
                    'price' => OptionHelper::getData('stripe.subscription.payment.amount',''),
                    'quantity' => 1,
                ],
                ], 
                'after_completion' => [
                    'type' => 'redirect',
                    'redirect' => ['url' => url("stripe/subscription/{$user->slug}/".'payment/{CHECKOUT_SESSION_ID}')],
                ],
            ]);
            // $user->setProgress('cortext-subscription-payment-id',$payment->id);
            // $user->setProgress('cortext-subscription-payment','pending');
            return redirect($payment->url);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error',$th->getMessage());
        }
    }
    public function subscription_payment(Request $request,User $user,SubscriptionPlan $subscriptionPlan,$type,$payment){
        $payment=Payment::stripe()->checkout->sessions->retrieve($payment); 
        // $user->setProgress('cortext-subscription-payment-session',$payment->id); 
        // $user->setProgress('cortext-subscription-payment-transation',$payment->payment_intent);  
        if($payment->payment_status=="paid"){
            $intent=Payment::stripe()->paymentIntents->retrieve($payment->payment_intent); 
        //     $user->setProgress('cortext-subscription-payment','paid');
        //     $plan=$user->progress('cortext-subscription-payment-plan','');
            $coupon=$user->progress('cortext-subscription-payment-coupon','');
            if($type=="combo"){
                $email=$user->progress('cortext-subscription-payment-email','');
                UserSubscription::store([
                    'payment_id'=>$intent->id,
                    'stripe_id' =>$payment->id,
                    'user_id'=>$user->id,
                    'pay_by'=>$user->id,
                    'subscription_plan_id'=>$subscriptionPlan->id,
                    'payment_status'=>$intent->id,
                    'amount'=>$intent->amount/100,
                    'status'=>"subscribed",
                    'email'=>$email,
                    'expire_at'=>$subscriptionPlan->end_plan,
                    'coupon'=>$coupon
                ]);
                if(!empty($email)&& User::where('email',$email)->where('id','!=',$user->id)->count()>0){
                    $cuser=User::where('email',$email)->first();
                    UserSubscription::store([
                        'payment_id'=>$intent->id,
                        'stripe_id' =>$payment->id,
                        'user_id'=>$cuser->id,
                        'pay_by'=>$user->id,
                        'subscription_plan_id'=>$subscriptionPlan->id,
                        'payment_status'=>'refered',
                        'amount'=>$intent->amount/100,
                        'status'=>"subscribed",
                        'expire_at'=>$subscriptionPlan->end_plan,
                    ]);
        //             $cuser->setProgress('cortext-subscription-payment-ref',$payment->payment_intent);
        //             $cuser->setProgress('cortext-subscription-payment','paid');
        //             $cuser->setProgress('cortext-subscription-payment-year',$user->progress('cortext-subscription-payment-year'));
                }

            }else{
                UserSubscription::store([
                    'payment_id'=>$intent->id,
                    'stripe_id' =>$payment->id,
                    'user_id'=>$user->id,
                    'pay_by'=>$user->id,
                    'subscription_plan_id'=>$subscriptionPlan->id,
                    'payment_status'=>$intent->status,
                    'amount'=>$intent->amount/100,
                    'status'=>"subscribed",
                    'expire_at'=>$subscriptionPlan->end_plan,
                    'coupon'=>$coupon
                ]);
            }
            
            // $intent=Payment::stripe()->paymentIntents->retrieve($payment->payment_intent);
            $transation=new PaymentTransation;
            $transation->stype='subscription';
            $transation->user_id=$user->id;
            $transation->slug=$payment->payment_intent; 
            $transation->amount=$intent->amount/100; 
            $transation->status="paid";
            $transation->content="Subscription $type payment \n Amount : ".($intent->amount/100)." \n Amount Recive: ".($intent->amount_received/100)."  ";
            $transation->save();
            
        }else{
        //     $transation=new PaymentTransation;
        //     $transation->stype='subscription';
        //     $transation->user_id=$user->id;
        //     $transation->slug=$payment->payment_intent??$payment->id;
        //     $transation->save();
        //     if($payment->status=="open"){
        //         return redirect()->route('learn.index')->with('error',"Subscription payment in-complete");
        //     }else{
        //         return redirect()->route('learn.index')->with('error',"Subscription payment Failed");
        //     }
        }

        return redirect()->route('subscription-payment.notice',$payment->payment_intent);

    }
}
