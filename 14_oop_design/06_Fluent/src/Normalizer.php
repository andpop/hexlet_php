<?php
namespace App;

require __DIR__ . '/../vendor/autoload.php';

use Tightenco\Support\Collection;

function normalize($raw)
{
    $rawCollection = collect($raw);

    $normalized = $rawCollection->map(fn($value) => 
        [
            'name' => strtolower(trim($value['name'])),
            'country' => strtolower(trim($value['country']))
        ]);

    $uniqued = $normalized->unique(fn($value) =>
        $value['name'] . $value['country']);

    $grouppedByCountry = $uniqued->mapToGroups(fn($value) =>
        [$value['country'] => $value['name']]);

    $sortedByTown = $grouppedByCountry->map(fn($value) =>
        $value->sort()->values()->all());

    $sortedByCountry = $sortedByTown->sortKeys();

    return $sortedByCountry->all();
}


$raw = [
    [
        'name' => 'istambul',
        'country' => 'turkey'
    ],
    [
        'name' => 'Moscow ',
        'country' => ' Russia'
    ],
    [
        'name' => 'iStambul',
        'country' => 'tUrkey'
    ],
    [
        'name' => 'antalia',
        'country' => 'turkeY '
    ],
    [
        'name' => 'samarA',
        'country' => '  ruSsiA'
    ],
    [
        'name' => 'istambul',
        'country' => 'usa'
    ],
];

$actual = normalize($raw);
var_dump($actual);
