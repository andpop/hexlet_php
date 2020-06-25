<?php

namespace App;
require __DIR__ . '/../vendor/autoload.php';

$booking = new Booking();
// $booking->book('10-11-2008', '12-11-2008');
$result = $booking->book('11-11-2008', '13-11-2008');
$result1 = $booking->book('10-11-2008', '12-11-2008');
var_dump($result1);
