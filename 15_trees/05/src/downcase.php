<?php

namespace App\downcaseFileNames;

require __DIR__ . '/../vendor/autoload.php';

use function Php\Immutable\Fs\Trees\trees\mkdir;
use function Php\Immutable\Fs\Trees\trees\mkfile;
use function Php\Immutable\Fs\Trees\trees\isFile;
use function Php\Immutable\Fs\Trees\trees\getChildren;
use function Php\Immutable\Fs\Trees\trees\getName;
use function Php\Immutable\Fs\Trees\trees\getMeta;

function downcaseFileNames($tree)
{
    $name = getName($tree);
    $meta = getMeta($tree);

    if (isFile($tree)) {
        $newName = mb_strtolower($name);
        return mkfile($newName, $meta);
    }

    $children = getChildren($tree);

    $newChildren = array_map(function ($child) {
        return downcaseFileNames($child);
    }, $children);

    $newTree = mkdir($name, $newChildren, $meta);

    return $newTree;
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

// $tree = mkdir('/', [
//     mkdir('etc', [
//       mkfile('bashrc'),
//       mkfile('consul.cfg'),
//     ]),
//     mkfile('hexletrc'),
//     mkdir('bin', [
//       mkfile('ls'),
//       mkfile('cat'),
//     ]),
//   ]);

// dfs($tree);

// $newTree = changeOwner($tree, 'popov');
// print_r($newTree);

$tree = mkdir('/', [
    mkdir('eTc', [
      mkdir('NgiNx'),
      mkdir('CONSUL', [
        mkfile('config.JSON'),
      ]),
    ]),
    mkfile('hOsts'),
  ]);

$actual = downcaseFileNames($tree);
print_r($actual);
