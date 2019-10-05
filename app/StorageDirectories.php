<?php

namespace App;

class StorageDirectories
{
    /**
     * The storage path for the execution environment.
     *
     * @var string
     */
    public const PATH = '/tmp/storage';

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public static function create()
    {
        $path = self::PATH;

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
