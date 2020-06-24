<?php

namespace App;

// BEGIN (write your solution here)
use Tightenco\Support\Collection;

class DeckOfCards
{
    private $cards;

    public function __construct(array $cardsUniq)
    {
        array_push($cardsUniq, ...$cardsUniq, ...$cardsUniq, ...$cardsUniq);
        $this->cards = $cardsUniq;
    }

    public function getShuffled()
    {
        $collection = collect($this->cards);
        $shuffledCollection = $collection->shuffle();

        return $shuffledCollection->all();
    }
}
// END
