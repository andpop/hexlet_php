<?php

function isAbsolutePath($path)
{
    return $path[0] === '/';
}

function deleteLastSlash($path)
{
    if ($path[strlen($path) - 1] === '/') {
        return substr($path, 0, strlen($path) - 1);
    } else {
        return $path;
    }
}

function cd($current, $move)
{
    if (isAbsolutePath($move)) {
        return $move;
    }

    $resultDirs = explode('/', $current);
    $moveDirs = explode('/', $move);

    foreach ($moveDirs as $dir) {
        if ($dir === '..') {
            array_pop($resultDirs);
        } elseif ($dir !== '.') {
            array_push($resultDirs, $dir);
        }
    }

    // print_r($currentDirs);
    $result = deleteLastSlash(implode('/', $resultDirs));

    return $result;
}

$path = cd('/current/path', '../');
echo "$path \n";
