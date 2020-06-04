<?php

require_once './Points.php';

use function App\Points\makeDecartPoint;
use function App\Points\getX;
use function App\Points\getY;
use function App\Points\getQuadrant;

function makeRectangle($startPoint, $width, $height)
{
    return [
        'startPoint' => $startPoint,
        'width' => $width,
        'height' => $height
    ];
}

function getStartPoint($rectangle)
{
    return $rectangle['startPoint'];
}

function getWidth($rectangle)
{
    return $rectangle['width'];
}

function getHeight($rectangle)
{
    return $rectangle['height'];
}

function containsOrigin($rectangle)
{
    $leftTopPoint = getStartPoint($rectangle);

    $rightBottomPointX = getX($leftTopPoint) + getWidth($rectangle);
    $rightBottomPointY = getY($leftTopPoint) - getHeight($rectangle);
    $rightBottomPoint = makeDecartPoint($rightBottomPointX, $rightBottomPointY);

    $quadrant1 = getQuadrant($leftTopPoint);
    $quadrant2 = getQuadrant($rightBottomPoint);
    
    if (is_null($quadrant1) || is_null($quadrant2)) {
        return false;
    }
    
    return abs($quadrant1 - $quadrant2) == 2;
}

function containsOrigin_teacher($rectangle)
{
    $point1 = getStartPoint($rectangle);
    $point2 = makeDecartPoint(getX($point1) + getWidth($rectangle), getY($point1) - getHeight($rectangle));
    return getQuadrant($point1) === 2 && getQuadrant($point2) === 4;
}

$p2 = makeDecartPoint(-4, 3);
$rectangle2 = makeRectangle($p2, 4, 3);

echo containsOrigin($rectangle2) . "\n";
