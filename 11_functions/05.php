<?php
function union($first, ...$rest)
{
    $tempArray = array_unique(array_merge($first, ...$rest));
    $result = [];

    foreach ($tempArray as $item) {
        $result[] = $item;
    }

    return $result;
}

function union_teacher($first, ...$rest)
{
    $mapWithUniqKeys = array_unique(array_merge($first, ...$rest));
    return array_values($mapWithUniqKeys);
}


print_r(union([3, 2], [2, 2, 1]));