<?php
namespace App;

$autoloadPath = __DIR__ . '/../vendor/autoload.php';
require_once $autoloadPath;

use function App\Comparator\compare;

echo compare('abcd##e', 'b');
