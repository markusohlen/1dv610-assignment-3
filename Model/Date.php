<?php

namespace model;

/**
 * Readonly data structure for a user
 */
class Date
{
    private $year;
    private $month;
    private $day;

    public function __construct(string $year, string $month, string $day)
    {
        $this->year = $year;
        $this->month = $month;
        $this->day = $day;
    }

    public function getDate() : string
    {
        $year = $this->year;
        $month = $this->month;
        $day = $this->day;
        
        return "$year-$month-$day";
    }
}
