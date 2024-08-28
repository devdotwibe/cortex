<?php

namespace App\Jobs;

use App\Models\UserProgress;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ExpireSubscription implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        UserProgress::whereIn('name',['intensive-workshop-payment','stripe.subscription.payment.amount'])->whereIn('user_id',UserProgress::where('name','cortext-subscription-payment-year')->where('value',(date('Y')-1)."-".(date('Y')))->select('user_id'))->where('value','paid')->update(['value'=>'expired']);
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
    }
}
