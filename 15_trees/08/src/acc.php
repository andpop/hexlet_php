<?php

namespace App\aggregate;

require __DIR__ . '/../vendor/autoload.php';

use function Php\Immutable\Fs\Trees\trees\mkdir;
use function Php\Immutable\Fs\Trees\trees\mkfile;
use function Php\Immutable\Fs\Trees\trees\isFile;
use function Php\Immutable\Fs\Trees\trees\getChildren;
use function Php\Immutable\Fs\Trees\trees\getName;
use function Php\Immutable\Fs\Trees\trees\getMeta;
use function Php\Immutable\Fs\Trees\trees\array_flatten;

function findEmptyDirPaths($tree)
{
    $name = getName($tree);
    $children = getChildren($tree);

    // Если детей нет, то добавляем директорию
    if (count($children) === 0) {
        return $name;
    }

    // Удаляем файлы, они нас не интересуют 
    $dirNames = array_filter($children, fn($child) => !isFile($child));
    // Ищем пустые директории внутри текущей
    $emptyDirNames = array_map(fn($dir) => findEmptyDirPaths($dir), $dirNames);

    // array_flatten выправляет массив, так что он остается плоским
    return array_flatten($emptyDirNames);
    // return $emptyDirNames;
}

$tree = mkdir('/', [
    mkdir('etc', [
        mkdir('apache'),
        mkdir('nginx', [
            mkfile('nginx.conf'),
        ]),
        mkdir('consul', [
            mkfile('config.json'),
            mkdir('data'),
        ]),
    ]),
    mkdir('logs'),
    mkfile('hosts'),
]);

$actual = findEmptyDirPaths($tree);

print_r($actual) . PHP_EOL;
