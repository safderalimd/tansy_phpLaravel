<?php

namespace App\Http\SMS;

use Illuminate\Support\ServiceProvider;
use App\Http\SMS\SMSManager;

class SMSServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('sms', function ($app) {
            return new SMSManager;
        });
    }
}
