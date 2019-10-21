<?php

namespace App\Services\Uscis;

/**
 * Parses form numbers for applications.
 *
 * @see https://github.com/spatie/regex
 */
class FormParser
{
    /**
     * Parse out the form number from the given value.
     *
     * @param  string  $value
     * @return mixed
     */
    public static function find($value)
    {
        preg_match('/Form I-[0-9]{3}/i', $value, $matches);

        if ($matches) {
            return $matches[0];
        }

        return null;
    }
}
