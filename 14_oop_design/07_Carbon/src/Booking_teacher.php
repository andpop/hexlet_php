<?php

namespace App;

use Carbon\Carbon;

// BEGIN
class Booking
{
    private $dates = [];

    public function book($begin, $end)
    {
        $carbonNewBegin = new Carbon($begin);
        $carbonNewEnd = new Carbon($end);
        if ($this->canBook($carbonNewBegin, $carbonNewEnd)) {
            $this->dates[] = [$carbonNewBegin, $carbonNewEnd];
            return true;
        }

        return false;
    }

    public function canBook($begin, $end)
    {
        if ($begin >= $end) {
            return false;
        }

        foreach ($this->dates as [$bookedBegin, $bookedEnd]) {
            $isIntersected = $begin < $bookedEnd && $end > $bookedBegin;
            if ($isIntersected) {
                return false;
            }
        }
        return true;
    }
}
// END