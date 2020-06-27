<?php

namespace App\generator;

require __DIR__ . '/../vendor/autoload.php';

use function Php\Immutable\Fs\Trees\trees\mkdir;
use function Php\Immutable\Fs\Trees\trees\mkfile;

// BEGIN (write your solution here)
function generator()
{
    $fs = mkdir('php-package', [
        mkfile('Makefile'),
        mkfile('README.md'),
        mkdir('dist'),
        mkdir('tests', [
            mkfile('test.php', ['type' => 'text/php'])
        ]),
        mkdir('src', [
            mkfile('index.php', ['type' => 'text/php'])
        ]),
        mkfile('phpunit.xml', ['type' => 'text/xml']),
        mkdir('assets', [
            mkdir('util', [
                mkdir('cli', [mkfile('LICENSE')])
            ])
        ], ['owner' => 'root', 'hidden' => false])
    ], ['hidden' => true]);
    return $fs;
}
// END
print_r(generator());

