<?php

namespace App\Normalizer;

require __DIR__ . '/../vendor/autoload.php';

use Tightenco\Support\Collection;

use function Stringy\create as s;

// BEGIN (write your solution here)

function getQuestions($text)
{
    $result = collect(s($text)->lines())
        ->filter(fn($line) => $line->endsWith('?'))
        ->map(fn($val) => (string)$val)
        ->join("\n");

    return $result;
}
// END

$text1 = <<<HEREDOC
lala\r\nr
ehu?
vie?eii
\n \t
i see you
/r \n
one two?\r\n\n
HEREDOC;

$actual1 = getQuestions($text1);
echo $actual1;
