<?php

namespace App\findFilesByName;

use function Php\Immutable\Fs\Trees\trees\isFile;
use function Php\Immutable\Fs\Trees\trees\getName;
use function Php\Immutable\Fs\Trees\trees\getChildren;

// BEGIN
function iter($node, $subStr, $ancestry, $acc)
{
    $name = getName($node);
    $newAncestry = ($name === '/') ? '' : "$ancestry/$name";
    if (isFile($node)) {
        if (strpos($name, $subStr) === false) {
            return $acc;
        }
        $acc[] = $newAncestry;
        return $acc;
    }

    return array_reduce(
        getChildren($node),
        function ($newAcc, $child) use ($subStr, $newAncestry) {
            return iter($child, $subStr, $newAncestry, $newAcc);
        },
        $acc
    );
}


function findFilesByName($root, $subStr)
{
    return iter($root, $subStr, '', []);
}
// END