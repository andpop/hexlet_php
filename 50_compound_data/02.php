<?php

function sumOfPairs($pair1, $pair2)
{
    return cons(car($pair1) + car($pair2), cdr($pair1) + cdr($pair2));
}

function reversePair($pair)
{
     return cons(cdr($pair), car($pair));
}

function findPrimitiveBox($pair)
{
    return null;
}

function findPrimitiveBox($pair)
{
    // echo toString($pair) . "\n" . '------------------------------------';
    // echo "\n" . '------------------------------------';

    $car = car($pair);
    $cdr = cdr($pair);

    if (isPair($car)) {
        echo "dfdfdfdfddf =====================";
        findPrimitiveBox($car);
    } else {
        if (isPair($cdr)) {
            findPrimitiveBox($cdr);
        } else {
            // return $pair;
            return cons(7, 5);
        }
    }
    
    // return cons(7, 5);
}
