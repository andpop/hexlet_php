<?php
namespace App\Comparator;

function normalizeString(string $seq): string
{
    $stack = new \Ds\Stack();

    foreach (str_split($seq) as $char) {
        if ($char !== '#') {
            $stack->push($char);
        } else {
            if (!$stack->isEmpty()) {
                $stack->pop($char);
            }
        }
    }
    return implode('', array_reverse($stack->toArray()));
}

function compare(string $seq1, string $seq2): bool
{
    $str1 = normalizeString($seq1);
    $str2 = normalizeString($seq2);

    return $str1 === $str2;
}
