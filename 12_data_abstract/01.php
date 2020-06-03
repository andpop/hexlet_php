<?php

function calculateDistance($p1, $p2)
{
    return sqrt(($p1[0] - $p2[0]) ** 2 + ($p1[1] - $p2[1]) ** 2);
}

$point1 = [0, 0];
$point2 = [3, 4];

echo calculateDistance($point1, $point2) . "\n";

