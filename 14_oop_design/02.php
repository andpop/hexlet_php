<?php

namespace App;

class Truncater
{
    public const OPTIONS = [
        'separator' => '...',
        'length' => 200,
    ];

    private $options;

    // BEGIN (write your solution here)
    public function __construct(array $options = [])
    {
        $this->options = array_merge(self::OPTIONS, $options);
    } 

    public function truncate(string $subject, array $options = []): string
    {
        $length = $options['length'] ?? $this->options['length'];
        $separator = $options['separator'] ?? $this->options['separator'];

        if (mb_strlen($subject) <= $length) {
            return $subject;
        } else {
            $result = mb_substr($subject, 0, $length);
            return "{$result}{$separator}";
        }
    }
    // END
}

$truncater = new Truncater();

$actual = $truncater->truncate('one two');
$actual = $truncater->truncate('one two', ['length' => 6]);

echo $actual . PHP_EOL;