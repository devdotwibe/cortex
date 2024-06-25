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
        // Set up Stripe PHP library with your secret key
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        try {
            // Check if customer already has a Stripe customer ID
            if (!$request->user()->stripe_customer_id) {
                // Create a new Stripe customer and attach payment method
                $stripeCustomer = Stripe\Customer::create([
                    'email' => $request->user()->email,
                    'source' => $request->stripeToken, // Stripe token obtained from Stripe Elements
                ]);

                // Save the customer ID to your user record in your database
                $request->user()->update(['stripe_customer_id' => $stripeCustomer->id]);
            } else {
                // Retrieve the existing Stripe customer
                $stripeCustomer = Stripe\Customer::retrieve($request->user()->stripe_customer_id);
                // Attach the payment method (use the new Payment Method API for SCA-ready payments)
                $paymentMethod = Stripe\PaymentMethod::create([
                    'type' => 'card',
                    'card' => [
                        'token' => $request->stripeToken,
                    ],
                ]);

                // Attach the payment method to the customer
                $stripeCustomer->attachPaymentMethod($paymentMethod->id);
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
            $subscription->amount =$payment_intent->amount;
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

