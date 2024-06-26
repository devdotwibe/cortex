<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Stripe;
use App\Models\Subscription;
use Carbon\Carbon;
use Stripe\PaymentIntent;
use Stripe\PaymentMethod;

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

                // Check if the payment method is specified in the request
                $paymentMethodId = $request->input('payment_method_id');

                if ($paymentMethodId) {
                    // Use the provided payment method ID
                    $paymentMethod = PaymentMethod::retrieve($paymentMethodId);
                } else {
                    // Use the default payment method
                    $paymentMethod = PaymentMethod::retrieve($stripeCustomer->invoice_settings->default_payment_method);
                }

                // Attach the payment method if it's not already attached
                if (!$paymentMethod->customer) {
                    // Attach the payment method to the customer
                    $stripeCustomer->payment_methods->attach($paymentMethod->id);
                }
            }

            // Create a PaymentIntent for the payment
            $paymentIntent = PaymentIntent::create([
                'amount' => 2000, // Amount in cents, e.g., $20.00
                'currency' => 'usd',
                'customer' => $stripeCustomer->id, // Use the customer ID saved in your database
                'payment_method' => isset($paymentMethod) ? $paymentMethod->id : $stripeCustomer->invoice_settings->default_payment_method,
                'confirm' => true, // Confirm the PaymentIntent immediately
                'return_url' => route('stripe.payment'), // Specify your return URL here
                'automatic_payment_methods' => ['enabled' => true],
            ]);

            // Create a subscription record in your database
            $subscription = new Subscription();
            $subscription->user_id = $request->user()->id;
            $subscription->payment_id = $paymentIntent->id;
            $subscription->customer_id = $stripeCustomer->id;
            $subscription->amount = $paymentIntent->amount / 100; // Convert amount back to dollars
            $subscription->start_date = Carbon::now();
            $subscription->expiration_date = Carbon::now()->addYear()->month(5)->day(30);
            $subscription->save();

            // Redirect to a success page or return a success response
            return redirect()->route('stripe.payment')->with('success', 'Payment method added successfully.');

        } catch (\Exception $e) {
            // Handle Stripe API errors
            return redirect()->back()->with('error', 'Failed to add payment method: ' . $e->getMessage());
        }
    }
}
