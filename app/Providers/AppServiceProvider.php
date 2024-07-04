<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * The helper mappings for the application.
     *
     * @var array
     */
    protected $helpers = [
        'get_option' => [\App\Support\Helpers\OptionHelper::class,"getData"],
        'set_option' => [\App\Support\Helpers\OptionHelper::class,"setData"],
        'remove_option' => [\App\Support\Helpers\OptionHelper::class,"deleteData"],
    ];
    /**
     * Register any application services.
     */
    public function register(): void
    {
        foreach ($this->helpers as $alias => $method) {
            if (!function_exists($alias)) { 
                eval("function {$alias}(...\$args) { return {$method[0]}::{$method[1]}(...\$args); }");
            }
        }

        $this->mergeConfigFrom(
            base_path('config/stripe.php'), 'stripe'
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
