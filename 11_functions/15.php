<?php
require_once('./vendor/autoload.php');

use Funct\Collection;

function enlargeArrayImage($image)
{
    $repeatItemsInArray = function ($arr) {
        $result = [];
        foreach ($arr as $item) {
            $result[] = $item;
            $result[] = $item;
        }
        return $result;
    };

    $result = [];

    $result = array_map($repeatItemsInArray, $image);
    $result = $repeatItemsInArray($result);

    return $result;
}

/* Решение учителя
function duplicateEach(array $items)
{
    return Collection\flatten(
        array_map(fn($item) => [$item, $item], $items)
    );
}

function enlargeArrayImage($matrix)
{
    $horizontallyStretched = array_map(fn($col) => duplicateEach($col), $matrix);
    return duplicateEach($horizontallyStretched);
}
*/

$image = [
    ['*','*','*','*'],
    ['*',' ',' ','*'],
    ['*',' ',' ','*'],
    ['*','*','*','*']
  ];

function print_image($image)
{
    foreach ($image as $line) {
        foreach ($line as $char) {
            echo $char;
        }
        echo "\n";
    }
}

print_image(enlargeArrayImage($image));
