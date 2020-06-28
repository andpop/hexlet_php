<?php

namespace App\aggregate;

require __DIR__ . '/../vendor/autoload.php';

use function Php\Immutable\Fs\Trees\trees\mkdir;
use function Php\Immutable\Fs\Trees\trees\mkfile;
use function Php\Immutable\Fs\Trees\trees\isFile;
use function Php\Immutable\Fs\Trees\trees\getChildren;
use function Php\Immutable\Fs\Trees\trees\getName;
use function Php\Immutable\Fs\Trees\trees\getMeta;

// function getNodesCount($tree)
// {
//     if (isFile($tree)) {
//         return 1;
//     }

//     $children = getChildren($tree);
//     $descendantsCount = array_map(fn($child) => getNodesCount($child), $children);

//     echo getName($tree) . ': ' . count($descendantsCount) . PHP_EOL;
//     print_r($descendantsCount);
//     echo "--------------------------------------\n";

//     return 1 + array_sum($descendantsCount);
// }

function getHiddenFilesCount($tree)
{
    if (isFile($tree)) {
        return substr(getName($tree), 0, 1) === '.' ? 1 : 0;
    }

    $children = getChildren($tree);
    $descendantsCount = array_map(fn($child) => getHiddenFilesCount($child), $children);

    echo getName($tree) . ': ' . count($descendantsCount) . PHP_EOL;

    return array_sum($descendantsCount);
}

function getHiddenFilesCount_teacher($node)
{
    $name = getName($node);
    if (isFile($node)) {
        $firstSymbol = substr($name, 0, 1);
        return $firstSymbol === "." ? 1 : 0;
    }

    $children = getChildren($node);

    return array_reduce($children, fn($acc, $child) => $acc + getHiddenFilesCount($child));
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

$actual = getHiddenFilesCount($tree);

echo $actual . PHP_EOL;
