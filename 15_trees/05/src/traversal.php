<?php

namespace App\traversal;

require __DIR__ . '/../vendor/autoload.php';

use function Php\Immutable\Fs\Trees\trees\mkdir;
use function Php\Immutable\Fs\Trees\trees\mkfile;
use function Php\Immutable\Fs\Trees\trees\isFile;
use function Php\Immutable\Fs\Trees\trees\getChildren;
use function Php\Immutable\Fs\Trees\trees\getName;
use function Php\Immutable\Fs\Trees\trees\getMeta;

function dfs($tree)
{
    $name = getName($tree);
    echo $name . PHP_EOL;

    if (isFile($tree)) {
        return;
    }

    $children = getChildren($tree);
    array_map(fn($child) => dfs($child), $children);
}

function changeOwner($tree, $owner)
{
    $name = getName($tree);
    $newMeta = getMeta($tree);
    $newMeta['owner'] = $owner;

    if (isFile($tree)) {
        return mkfile($name, $newMeta);
    }

    $children = getChildren($tree);

    $newChildren = array_map(function ($child) use ($owner) {
        return changeOwner($child, $owner);
    }, $children);

    $newTree = mkdir($name, $newChildren, $newMeta);

    return $newTree;
}

$tree = mkdir('/', [
    mkdir('etc', [
      mkfile('bashrc'),
      mkfile('consul.cfg'),
    ]),
    mkfile('hexletrc'),
    mkdir('bin', [
      mkfile('ls'),
      mkfile('cat'),
    ]),
  ]);

// dfs($tree);

$newTree = changeOwner($tree, 'popov');
print_r($newTree);
