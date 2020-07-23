<?php

// require_once './src/Func.php';
require __DIR__ . '/../vendor/autoload.php';

// Первый вариант
use function App\Func\func;
echo func(1) . "\n";

// Второй вариант
echo App\Func\func(2) . "\n";

// Первый вариант
use App\MyClass1;
$obj1 = new MyClass1();
echo $obj1->func1(3) . "\n";

// Второй вариант
$obj2 = new App\MyClass1();
echo $obj2->func1(4) . "\n";
