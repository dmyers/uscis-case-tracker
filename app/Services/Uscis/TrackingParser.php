<?php

namespace App\Services\Uscis;

/**
 * Parses tracking numbers for packages.
 *
 * @see https://github.com/spatie/regex
 * @see https://github.com/jkeen/tracking_number_data/tree/master
 * @see https://github.com/jkeen/tracking_number/tree/master/lib
 */
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
