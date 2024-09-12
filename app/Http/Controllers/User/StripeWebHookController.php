<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller; 
use Illuminate\Http\Request;


class StripeWebHookController extends Controller
{

    public function handlewebhook(Request $request)
    {
        $payload= $request->getContent();
        $sig_header=$request->server('HTTP_STRIPE_SIGNATURE');
        $event=null;
        try{
            $event = \Stripe\Webhook::constructEvent($payload,$sig_header,env('STRIPE_WEBHOOK_SECRET'));
        }
        catch (\UnexpectedValueException $e){
            return response()->json(['error'=>'Invalid payload'],400);
        } catch (\Stripe\Exception\SignatureVerificationException $e){
            return response()->json(['error'=> 'Invalid signature'],400);
        }
        switch($event->type){
            case 'payment_intent.succeeded':
                $paymentIntent= $event->data->object;
                $paymentIntentId=$paymentIntent->id;
                // $subscription =Subscription::where('payment_id',$paymentIntentId)->first();
                // if($subscription){
                //     $subscription->status ='active';
                //     $subscription->save();
                // }
                return response()->json(['status'=>'success','message'=>'Payment succeeded and subscription activated']);

            case 'payment_intent.payment_failed':
                $paymentIntent = $event->data->object;
                $paymentIntentId= $paymentIntent->id;
                // $subscription = Subscription::where('payment_id',$paymentIntentId)->first();
                // if($subscription){
                //     $subscription->status='inactive';
                //     $subscription->save();
                // }
                return response()->json(['status'=>'success','message'=>'Payment failed']);
            default:
               return response()->json(['status'=>'success','message'=>'Received unexpected value']);

        }

    }
}

