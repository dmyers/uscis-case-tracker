<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class StorageServiceProvider extends ServiceProvider
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
        $path = storage_path();

        $directories = [
            $path.'/app',
            $path.'/bootstrap/cache',
            $path.'/framework/cache',
            $path.'/framework/views',
        ];

        // Make sure the storage directories exist
        foreach ($directories as $directory) {
            if (!is_dir($directory)) {
                mkdir($directory, 0755, true);
            }
        }
    }
}
