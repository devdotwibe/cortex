<?php

namespace App\Support\Plugin;


use Exception;
use Stripe\Customer;
use Stripe\StripeClient;
 
class Payment
{ 
     
    protected $customerID;

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
            'api_key' => $options['api_key'] ?? config('cashier.secret'),
            'stripe_version' => static::STRIPE_VERSION,
            'api_base' => static::$apiBaseUrl,
        ], $options));
    }
    public static function resourceUrl($id)
    {
        if (null === $id) {
            $class = static::class;
            $message = 'Could not determine which URL to request: '
               . "{$class} instance has invalid ID: {$id}";

            throw new Exception($message);
        } 
        $base = '/v1/customers';
        $extn = \urlencode($id);

        return "{$base}/{$extn}";
    }

    /**
     * @return string the full API URL for this API resource
     */
    public function instanceUrl()
    {
        return static::resourceUrl($this->customerID);
    }
}

