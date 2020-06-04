<?php

namespace App\Points;

function makeDecartPoint($x, $y)
{
     return [
         'angle' => atan2($y, $x),
         'radius' => sqrt($x ** 2 + $y ** 2)
     ];
}

// BEGIN (write your solution here)
function getX($point)
{
    return $point['radius'] * cos($point['angle']);
}

function getY($point)
{
    return $point['radius'] * sin($point['angle']);
}
// END
