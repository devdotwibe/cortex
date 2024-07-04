<?php

namespace App\Support\Plugin;


use Exception;
use Stripe\Customer;
use Stripe\StripeClient;
 
class Payment
{ 
      
    const STRIPE_VERSION = '2024-06-20';
    public static $apiBaseUrl ="https://api.stripe.com";

    public static $customerModel = 'App\\Models\\User';


    /**
     * Get the customer instance by its Stripe ID.
     *
     * @param  \Stripe\Customer|string|null  $stripeId
     * @return \App\Trait\Billable|null
     */
    public static function findUser($stripeId)
    {
        $stripeId = $stripeId instanceof Customer ? $stripeId->id : $stripeId;

        return $stripeId ? (new static::$customerModel)->where('stripe_id', $stripeId)->first() : null;
    }

    /**
     * Get the Stripe SDK client.
     *
     * @param  array  $options
     * @return \Stripe\StripeClient
     */
    public static function stripe(array $options = [])
    {
        return new StripeClient(array_merge([
            'api_key' => $options['api_key'] ?? config('stripe.secret'),
            'stripe_version' => static::STRIPE_VERSION,
            'api_base' => static::$apiBaseUrl,
        ], $options));
    } 
}

