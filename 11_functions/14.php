<?php

function without(array $items, ...$values)
{
    $filtered = array_filter($items, function ($item) use ($values) {
        //return $item !== $value;

        return !in_array($item, $values);
    });
    // Сбрасываем ключи
    return array_values($filtered);
}
