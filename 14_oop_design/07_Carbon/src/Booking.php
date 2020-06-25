<?php
namespace App;

use Carbon\Carbon;

// BEGIN (write your solution here)
class Booking
{
    private $bookedDates = [];

    // public function __create()
    // {
    //     $this->dates = [];
    // }

    private function isValidDates($startDate, $endDate)
    {
        return ($startDate->diffInDays($endDate, false) >= 1);
    }

    public function book(string $date1, string $date2)
    {
        $startDate = Carbon::createFromFormat('d-m-Y', $date1);
        $endDate = Carbon::createFromFormat('d-m-Y', $date2);

        if (!$this->isValidDates($startDate, $endDate)) {
            return false;
        }

        foreach ($this->bookedDates as [$currentStartDate, $currentEndDate]) {
            if (!($startDate->greaterThanOrEqualTo($currentEndDate) || $endDate->lessThanOrEqualTo($currentStartDate))) {
                return false;
            }
        }

        $this->bookedDates[] = [$startDate, $endDate];
        return true;
    }
}
// END
