<?php

function gcd($a, $b)
{
    return ($a % $b) ? gcd($b, $a % $b) : abs($b);
}

function normalizeFraction($ratio)
{
    $numer = getNumer($ratio);
    $denom = getDenom($ratio);

    $greaterCommonDelimiter = gcd($numer, $denom);
    $numer = $numer / $greaterCommonDelimiter;
    $denom = $denom / $greaterCommonDelimiter;

    return ['numer' => $numer, 'denom' => $denom];
}

function makeRational($numer, $denom)
{
    return normalizeFraction(['numer' => $numer, 'denom' => $denom]);
}

function getNumer($ratio)
{
    return $ratio['numer'];
}

function getDenom($ratio)
{
    return $ratio['denom'];
}

function add($ratio1, $ratio2)
{
    $numer = getNumer($ratio1) * getDenom($ratio2) + getNumer($ratio2) * getDenom($ratio1);
    $denom = getDenom($ratio1) * getDenom($ratio2);

    return makeRational($numer, $denom);
}

function sub($ratio1, $ratio2)
{
    $numer = getNumer($ratio1) * getDenom($ratio2) - getNumer($ratio2) * getDenom($ratio1);
    $denom = getDenom($ratio1) * getDenom($ratio2);

    return makeRational($numer, $denom);
}

function ratToString($rat)
{
    return getNumer($rat) . '/' . getDenom($rat);
}

$frac = makeRational(4, 8);
echo ratToString($frac);
