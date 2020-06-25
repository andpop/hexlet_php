<?php

namespace App\Normalizer;

use function Stringy\create as s;

// BEGIN
function getQuestions(string $text)
{
    $lines = s($text)->lines();
    $filteredLines = collect($lines)->filter(function ($line) {
        return $line->endsWith('?');
    });
    return implode("\n", $filteredLines->all());
}
// END
