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

function iter($node, $depth, $maxDepth)
{
    $name = getName($node);
    $children = getChildren($node);

    // Если детей нет, то добавляем директорию
    if (count($children) === 0) {
        return $name;
    }
    // Если это второй уровень вложенности, и директория не пустая,
    // то не имеет смысла смотреть дальше
    if ($depth === $maxDepth) {
        // Почему возвращается именно пустой массив?
        // Потому что снаружи выполняется array_flatten
        // Он раскрывает пустые массивы
        return [];
    }
    // Оставляем только директории
    $emptyDirPaths = array_filter($children, 'Php\Immutable\Fs\Trees\trees\isDirectory');
    // Не забываем увеличивать глубину
    $output = array_map(function ($child) use ($depth, $maxDepth) {
        return iter($child, $depth + 1, $maxDepth);
    }, $emptyDirPaths);

    // Перед возвратом "выпрямляем" массив
    return array_flatten($output);
}

function findEmptyPaths($tree, $maxDepth)
{
    // Начинаем с глубины 0
    return iter($tree, 0, $maxDepth);
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

$actual = findEmptyPaths($tree, 3);

print_r($actual) . PHP_EOL;
