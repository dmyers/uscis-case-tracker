<?php

namespace App\Services\Uscis;

use Goutte\Client as Goutte;
use GuzzleHttp\Client as Guzzle;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class UscisServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // for headers
        // @see https://github.com/xiaojunch/webscraping/blob/55fa42c2f4e9cdbaa99853429c68769612adf24f/checkH1b.py

        $this->app->singleton(UscisApi::class, function ($app) {
            $guzzle = new Guzzle([
                // 'base_uri' => 'https://egov.uscis.gov/',
                'headers' => [
                    'Accept'          => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*',
                    'Accept-Encoding' => 'gzip, deflate',
                    'Accept-Language' => 'en-US,en;q=0.9',
                    'Cache-Control'   => 'no-cache',
                    // 'Content-Type'    => 'application/x-www-form-urlencoded',
                    // 'Host'            => 'egov.uscis.gov',
                    'User-Agent'      => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.90 Safari/537.36',
                ],
                'verify' => false,
            ]);

            // $goutte = new Goutte();
            // $goutte->setClient($guzzle);
            return new UscisApi($guzzle);
        });

        $this->app->alias(UscisApi::class, 'uscis');
    }

    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerRoutes();
    }

    /**
     * Register the package routes.
     *
     * @return void
     */
    protected function registerRoutes()
    {
        Route::group($this->routeConfiguration(), function () {
            $this->loadRoutesFrom(__DIR__.'/routes.php');
        });
    }

    /**
     * Get the Nova route group configuration array.
     *
     * @return array
     */
    protected function routeConfiguration()
    {
        return [
            'namespace'  => 'App\Services\Uscis',
            'middleware' => 'api',
            'as'         => 'uscis.',
        ];
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['uscis'];
    }
}
