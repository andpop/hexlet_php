<?php

namespace App\Converter;

use stdClass;

// BEGIN (write your solution here)
function toStd(array $data)
{
    $result = new \stdClass();
    foreach ($data as $key => $value) {
        $result->$key = $value;
    }

    return $result;
}
// END

$data = [
    'key' => 'value',
    'key2' => 'value2',
];
$config = toStd($data);
var_dump($config);
