<?php

function grep($string, $path)
{
    $result = [];
    
    foreach (glob($path) as $filename) {
        if (is_file($filename) && is_readable($filename)) {
            $lines = file($filename);
            foreach ($lines as $line) {
                if (strpos($line, $string) !== false) {
                    $result[] = $line;
                }
            }
        }
    }

    return $result;
}

$path = './*';
$string = 'test';

grep($string, $path);
