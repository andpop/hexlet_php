<?php

function myReduce($coll, callable $callback, $init = null)
{
    $acc = $init;
    foreach ($coll as $item) {
        $acc = $callback($acc, $item); // Заменяем старый аккумулятор новым
    }
    return $acc;
}
