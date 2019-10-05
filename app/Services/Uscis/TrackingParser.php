<?php

namespace App\Services\Uscis;

use RuntimeException;

class TrackingParser
{
    /**
     * Parse out the tracking number from the given value.
     *
     * @param  string  $value
     * @return mixed
     */
    public static function find($value)
    {
        preg_match('/[0-9]{20,22}/i', $value, $matches);

        if ($matches) {
            return $matches[0];
        }

        return null;
    }
}
