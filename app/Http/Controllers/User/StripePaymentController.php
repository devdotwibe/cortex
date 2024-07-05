<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Support\Helpers\OptionHelper;
use App\Support\Plugin\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Checkout\Session;

class StripePaymentController extends Controller
{
    public function workshop(Request $request){
        /**
         * @var User
         */
        $user=Auth::user();
        $customerId=null;
        if(!empty($user->stripe_id)){
            try {
              $customer= Payment::stripe()->customers->retrieve($user->stripe_id);
              $customerId=$customer->id;
            } 
            catch (\Throwable $th) {
                //throw $th;
            }
        }
        if(empty($customerId)){
            try {
                $customer= Payment::stripe()->customers->create([
                    'name'=>$user->name,
                    'email'=>$user->email,
                ]);
                $user->stripe_id=$customer->id;
                $user->save();
            } 
            catch (\Throwable $th) {
                return redirect()->back()->with('error',$th->getMessage());
            }
        }
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
            return redirect()->back()->with('error',$th->getMessage());
        }
    }
    public function workshop_payment(Request $request,User $user,Session $payment){
        print_r($payment);
    }
}
