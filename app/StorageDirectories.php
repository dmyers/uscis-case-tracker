<?php

namespace App;

// @see https://github.com/laravel/vapor-core/search?q=StorageDirectories&unscoped_q=StorageDirectories
// @see https://github.com/laravel/vapor-core/blob/1129ef2773bd061f6faf58de98ef5f36ee6be9d1/stubs/fpmRuntime.php
// @see https://github.com/laravel/vapor-core/blob/9a486ab614e92c01cbd2d089b01cc0124c8eff0a/src/Runtime/StorageDirectories.php
// @see https://github.com/laravel/vapor-core/blob/2.0/src/VaporServiceProvider.php
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
