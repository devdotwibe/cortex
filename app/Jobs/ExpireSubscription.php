<?php

namespace App\Jobs;

use App\Models\UserProgress;
use App\Models\UserSubscription;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;

class ExpireSubscription implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        UserProgress::whereIn('name',['intensive-workshop-payment','stripe.subscription.payment.amount'])->whereIn('user_id',UserProgress::where('name','cortext-subscription-payment-year')->where('value',(date('Y')-1)."-".(date('Y')))->select('user_id'))->whereNotIn('user_id',UserProgress::where('name','cortext-subscription-payment-year')->where('value',(date('Y'))."-".(date('Y')+1))->select('user_id'))->where('value','paid')->update(['value'=>'expired']);
        UserSubscription::where('status','subscribed')->where(function($qry){
            $qry->orWhereNull('expire_at');
            $qry->orWhereDate('expire_at','<',Carbon::now()->toDateString());                        
        })->update([
            'status'=>"expired",
            'expire_at'=>Carbon::now()->toDateString()
        ]);
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
    }
}
