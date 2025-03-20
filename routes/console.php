<?php

use App\Jobs\CalculateExamAverage;
use App\Jobs\ExpireSubscription;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::job(new ExpireSubscription)->yearlyOn(5, 31, '00:15');

Schedule::job(new CalculateExamAverage)->everyTwoHours(); 

// Schedule::job(new CalculateExamAverage)->everyMinute(); 

