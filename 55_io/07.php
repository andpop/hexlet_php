<?php

namespace App\Safe;

function json_decode($json, $assoc = false)
{
    // BEGIN (write your solution here)
    $result = \json_decode($json, $assoc);
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new \Exception('JSON decode error');
    }

    return $result;
    // END
}