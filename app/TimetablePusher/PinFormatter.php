<?php

namespace TimetablePusher\TimetablePusher;

use Carbon\Carbon;

class PinFormatter
{

    protected $pins;
    protected $offsetFromUTC;

    /**
     * @param $pins
     * @param int $offsetFromUTC
     */
    public function __construct($pins, $offsetFromUTC = 0)
    {
        $this->pins = $pins;
        $this->offsetFromUTC = $offsetFromUTC;
    }

    /**
     * @return mixed
     */
    public function removePinsOlderThanCurrentDay()
    {
        $pins = $this->pins;

        // Get current day of week
        $carbon = Carbon::now('UTC')->addMinutes($this->offsetFromUTC);
        // Ensure days of week start at 0 (Monday) and end on 6 (Sunday)
        $dayOfWeek = $carbon->dayOfWeek === 0 ? 6 : $carbon->dayOfWeek - 1;

        for ($pinDay = 0; $pinDay < 7; $pinDay++) {
            if ($pinDay < $dayOfWeek) {
                $pins[$pinDay] = [];
            }
        }

        $this->pins = $pins;

        return $pins;
    }

    /**
     * @param $day
     * @return mixed
     */
    public function retrievePinsForDay($day)
    {
        $pins = $this->pins[$day];
        $this->pins = $pins;

        return $pins;
    }
}