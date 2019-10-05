<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Custom substring extension of alpha rule
        Validator::extend('alpha_start', function ($attribute, $value, $parameters, $validator) {
            $length = $parameters[0];
            $startPos = 0;
            $endPos = $startPos + $length;
            $valueStart = substr($value, $startPos, $endPos);
            return $validator->validateAlpha($attribute, $valueStart);
        });

        // Custom substring extension of numeric rule
        Validator::extend('numeric_end', function ($attribute, $value, $parameters, $validator) {
            $length = $parameters[0];
            $startPos = (strlen($value) - $length);
            $endPos = strlen($value);
            $valueEnd = substr($value, $startPos, $endPos);
            return $validator->validateNumeric($attribute, $valueEnd);
        });
    }
}
