<?php

namespace App\aggregate;

require __DIR__ . '/../vendor/autoload.php';

use function Php\Immutable\Fs\Trees\trees\mkdir;
use function Php\Immutable\Fs\Trees\trees\mkfile;
use function Php\Immutable\Fs\Trees\trees\isFile;
use function Php\Immutable\Fs\Trees\trees\getChildren;
use function Php\Immutable\Fs\Trees\trees\getName;
use function Php\Immutable\Fs\Trees\trees\getMeta;

function getNodesCount($tree)
{
    if (isFile($tree)) {
        return 1;
    }

    $children = getChildren($tree);
    
    $childrenCount = array_reduce($children, fn($acc, $child) => $acc + getNodesCount($child));

    return $childrenCount + 1;
}

function getFilesCount($tree)
{
    if (isFile($tree)) {
        echo "    File found: " . getName($tree) . " , return 1.\n";
        return 1;
    }

    $children = getChildren($tree);
    
    $childrenCount = 0;
    // $childrenCount = array_reduce($children, fn($acc, $child) => $acc + getFilesCount($child));
    $childrenCount = array_reduce($children, function ($acc, $child) {
        echo 'Current child in array_reduce: ' . getName($child) . PHP_EOL;
        echo "acc = {$acc}\n";
        var_dump($acc);
        echo "--------------------------------------------\n";
        return $acc + getFilesCount($child);
    }, 0);

    echo "Return from getFilesCount for " . getName($tree) . PHP_EOL;
    echo "Children count = " . $childrenCount . "\n";
    var_dump($childrenCount);
    echo "==========================================\n";
    return $childrenCount;
}
$tree = mkdir('ROOT_FOLDER', [
    mkdir('FOLDER_1', [
        mkdir('FOLDER_1_1', []),
        mkdir('FOLDER_1_2', [
            mkfile('file_1', ['size' => 800]),
        ]),
        mkdir('FOLDER_2', [
            mkfile('file_2', ['size' => 1200]),
            mkfile('file_3', ['size' => 8200]),
            mkfile('file_4', ['size' => 80]),
        ]),
    ]),
    mkfile('file_5', ['size' => 3500]),
    mkfile('file_6', ['size' => 1000]),
]);

$actual = getFilesCount($tree);

echo $actual . PHP_EOL;
