<?php

namespace App\tree;

require __DIR__ . '/../vendor/autoload.php';

use function Php\Immutable\Fs\Trees\trees\mkdir;
use function Php\Immutable\Fs\Trees\trees\mkfile;
use function Php\Immutable\Fs\Trees\trees\isFile;
use function Php\Immutable\Fs\Trees\trees\getChildren;
use function Php\Immutable\Fs\Trees\trees\getName;
use function Php\Immutable\Fs\Trees\trees\getMeta;

// BEGIN (write your solution here)
function compressImages($tree)
{
    $children = getChildren($tree);
    $newChildren = array_map(function ($child) {
        if (strpos($child['name'], 'jpg') !== false) {
            if (isset($child['meta']['size'])) {
                $child['meta']['size'] = ($child['meta']['size'] / 2);
            }
        }
        return $child;
    }, $children);

    $newTree = mkdir(getName($tree), $newChildren, getMeta($tree));

    return $newTree;
}
// END

