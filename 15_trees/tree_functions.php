<?php

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

