<?php
require_once('./vendor/autoload.php');

use Funct\Strings;
use Funct\Collection;

function slugify($sourceString): string
{
    $wordsWithSpaces = explode(' ', strtolower($sourceString));
    $words = [];
    foreach ($wordsWithSpaces as $word) {
        if (!empty($word)) {
            $words[] = $word;
        }
    }

    return implode('-', $words);
}

function slugify_teacher($text)
{
    $prepared = Strings\toLower($text);
    $parts = explode(' ', $prepared);
    $parts = Collection\compact($parts);
    return implode('-', $parts);
}

echo slugify_teacher('O la      lu');
