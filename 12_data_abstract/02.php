<?php

function makeDescartesPoint($x, $y)
{
    return ['x' => $x, 'y' => $y];
}

function getX($point)
{
    return $point['x'];
}

function getY($point)
{
    return $point['y'];
}

function makeSegment($beginPoint, $endPoint)
{
    return ['beginPoint' => $beginPoint, 'endPoint' => $endPoint];
}

function getBeginPoint($segment)
{
    return $segment['beginPoint'];
}


function getEndPoint($segment)
{
    return $segment['endPoint'];
}

function getMidpointOfSegment($segment)
{
    $x = ($segment['beginPoint']['x'] + $segment['endPoint']['x']) / 2;
    $y = ($segment['beginPoint']['y'] + $segment['endPoint']['y']) / 2;

    return makeDescartesPoint($x, $y);
}
