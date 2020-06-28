<?php

namespace App\aggregate;

require __DIR__ . '/../vendor/autoload.php';

use function Php\Immutable\Fs\Trees\trees\mkdir;
use function Php\Immutable\Fs\Trees\trees\mkfile;
use function Php\Immutable\Fs\Trees\trees\isFile;
use function Php\Immutable\Fs\Trees\trees\isDirectory;
use function Php\Immutable\Fs\Trees\trees\getChildren;
use function Php\Immutable\Fs\Trees\trees\getName;
use function Php\Immutable\Fs\Trees\trees\getMeta;
use function Php\Immutable\Fs\Trees\trees\array_flatten;

function iter($node, $path, $namePattern)
{
    $name = getName($node);
    
    if (isFile($node) && (strpos($name, $namePattern) !== false)) {
        return "$path/$name";
    }
    
    if (isFile($node)) {
        return [];
    }
    
    $children = getChildren($node);

    // $output = array_map(function ($child) use ($path, $namePattern) {
    //     $currentName = \Php\Immutable\Fs\Trees\trees\getName($child);
    //     $currentPath = \Php\Immutable\Fs\Trees\trees\isFile($child) ? $path : $path . "/" . $currentName;
    //     return iter($child, $currentPath, $namePattern);
    // }, $children);

    $output = array_map(
        fn ($child) => iter(
            $child,
            \Php\Immutable\Fs\Trees\trees\isFile($child)
                ? $path : $path . "/" . \Php\Immutable\Fs\Trees\trees\getName($child),
            $namePattern
        ),
        $children
    );

    return array_flatten($output);
}


function findFilesByName($tree, $namePattern)
{
    return iter($tree, '', $namePattern);
}

$tree = mkdir('/', [
    mkdir('etc', [
        mkdir('apache'),
        mkdir('nginx', [
            mkfile('nginx.conf', ['size' => 800]),
        ]),
        mkdir('consul', [
            mkfile('config.json', ['size' => 1200]),
            mkfile('data', ['size' => 8200]),
            mkfile('raft', ['size' => 80]),
        ]),
    ]),
    mkfile('hosts', ['size' => 3500]),
    mkfile('resolve', ['size' => 1000]),
]);

$actual = findFilesByName($tree, 'co');

print_r($actual) . PHP_EOL;
