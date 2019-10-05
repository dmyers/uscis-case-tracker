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
     * Ensure the necessary storage directories exist.
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

        foreach ($directories as $directory) {
            if (!is_dir($directory)) {
                mkdir($directory, 0755, true);
            }
        }
    }
}
