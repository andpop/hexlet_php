<?php
function getQuadrant($point)
{
    $x = getX($point);
    $y = getY($point);

    if ($x === 0 || $y === 0) {
        return null;
    }

    if ($x > 0 && $y > 0) {
        return 1;
    }

    if ($x > 0 && $y < 0) {
        return 4;
    }

    if ($x < 0 && $y > 0) {
        return 2;
    }

    if ($x < 0 && $y < 0) {
        return 3;
    }
}

function getSymmetricalPoint($point)
{
    return makePoint(-getX($point), -getY($point));
}

function calculateDistance($point1, $point2)
{
    return sqrt((getX($point2) - getX($point1)) ** 2 + (getY($point2) - getY($point1)) ** 2);
}

