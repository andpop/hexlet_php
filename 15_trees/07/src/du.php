<?php

namespace App\aggregate;

require __DIR__ . '/../vendor/autoload.php';

use function Php\Immutable\Fs\Trees\trees\mkdir;
use function Php\Immutable\Fs\Trees\trees\mkfile;
use function Php\Immutable\Fs\Trees\trees\isFile;
use function Php\Immutable\Fs\Trees\trees\getChildren;
use function Php\Immutable\Fs\Trees\trees\getName;
use function Php\Immutable\Fs\Trees\trees\getMeta;

// function getHiddenFilesCount($node)
// {
//     $name = getName($node);
//     if (isFile($node)) {
//         $firstSymbol = substr($name, 0, 1);
//         return $firstSymbol === "." ? 1 : 0;
//     }

//     $children = getChildren($node);

//     return array_reduce($children, fn($acc, $child) => $acc + getHiddenFilesCount($child));
// }

function getFileSize($file)
{
    return $file['meta']['size'];
}

function getNodeSize($node)
{
    if (isFile($node)) {
        return getFileSize($node);
    }

    $children = getChildren($node);
    return array_reduce($children, fn($acc, $child) => $acc + getNodeSize($child), 0);
}

function du($tree)
{
    $children = getChildren($tree);

    $childrenSizes = array_map(fn($node) => [getName($node), getNodeSize($node)], $children);
    usort($childrenSizes, fn($elem1, $elem2) => ($elem2[1] <=> $elem1[1]));

    return $childrenSizes;
}

$tree = mkdir('/', [
    mkdir('etc', [
        mkdir('apache', []),
        mkdir('nginx', [
            mkfile('.nginx.conf', ['size' => 800]),
        ]),
        mkdir('.consul', [
            mkfile('.config.json', ['size' => 1200]),
            mkfile('data', ['size' => 8200]),
            mkfile('raft', ['size' => 80]),
        ]),
    ]),
    mkfile('.hosts', ['size' => 3500]),
    mkfile('resolve', ['size' => 1000]),
]);

$actual = du($tree);

print_r($actual) . PHP_EOL;
