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
            $extension = $file->getClientOriginalExtension();
            return in_array(strtolower($extension), ['xls', 'xlsx', 'csv', 'ods']);
        });

        Validator::extend('not_at_symbol', function($attribute, $value)
        {
            return (strpos($value, '@') === false);
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
