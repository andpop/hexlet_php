<?php

namespace App;
require __DIR__ . '/../vendor/autoload.php';

$deck = new DeckOfCards([2, 3]);
print_r($deck->getShuffled());
