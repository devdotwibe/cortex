<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Stripe;
use App\Models\Subscription;
use Carbon\Carbon;

class StripeController extends Controller
{
    public function subscribe(Request $request)
    {
        return view("stripe.subscribe");
    }

    public function handlePayment(Request $request)
    { 
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
        try { 
            if (!$request->user()->stripe_customer_id) { 
                $stripeCustomer = Stripe\Customer::create([
                    'email' => $request->user()->email,
                    'source' => $request->stripeToken,
                ]);
                $request->user()->update(['stripe_customer_id' => $stripeCustomer->id]);
            } else { 
                $stripeCustomer = Stripe\Customer::retrieve($request->user()->stripe_customer_id);                 
                Stripe\Customer::createSource($stripeCustomer->id ,["source"=>$request->stripeToken]); 
            }
            $payment_intent =Stripe\PaymentIntent::create([
                'amount' => 2000,
                'currency' => 'usd',
                'automatic_payment_methods' => ['enabled' => true],
            ]);
            $subscription = new Subscription();
            $subscription->user_id = $request->user()->id;
            $subscription->payment_id = $payment_intent->id;
            $subscription->customer_id =$stripeCustomer->id;
            $subscription->amount =$payment_intent->amount/100;
            $subscription->start_date = Carbon::now();
            $subscription->expiration_date= Carbon::now()->addYear()->month(5)->day(30);
            $subscription->save();
            return redirect()->route('stripe.payment')->with('success', 'Payment method added successfully.');

        } catch (\Exception $e) {
            // Handle Stripe API errors
            return redirect()->back()->with('error', 'Failed to add payment method: ' . $e->getMessage());
        }
    }
}

