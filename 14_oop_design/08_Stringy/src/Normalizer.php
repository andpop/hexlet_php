<?php

namespace App\Normalizer;

require __DIR__ . '/../vendor/autoload.php';

use function Stringy\create as s;

// BEGIN (write your solution here)
use Tightenco\Support\Collection;

function getQuestions($text)
{
    $result = '';
    $lines = collect(s($text)->lines());
    $questions = $lines->filter(fn($line) => $line->endsWith('?'));
    $questions->dump();

    // foreach ($lines as $line) {
    //     if ($line->endsWith('?')) {
    //         echo $line . PHP_EOL;
    //     }
    // }

    return "dfdf";
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
