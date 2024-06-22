<?php

namespace App\Traits;

trait FormatNumberTrait
{
    function format_number($number)
    {
        $formatted = round($number, 2);
        if (floor($formatted) == $formatted) {
            return (int) $formatted;
        }
        return $formatted;
    }
}
