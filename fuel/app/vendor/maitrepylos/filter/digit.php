<?php

namespace Maitrepylos\Filter;

/**
 * Description of digit
 *
 * @author gg
 */
class Digit {

    /**
     * 
     *
     * Returns the string $value, removing all but digit characters
     *
     * @param  string $value
     * @return string
     */
    public static function filter($value) {

        // Filter for the value with mbstring
        $pattern = '/[^[:digit:]]/';

        return preg_replace($pattern, '', (string) $value);
    }

}

?>
