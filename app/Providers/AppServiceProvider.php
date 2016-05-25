<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('excel_file', function($attribute, $file, $parameters, $validator) {
            $extension = $file->clientExtension();
            return in_array(strtolower($extension), ['xls', 'xlsx', 'csv', 'ods']);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
