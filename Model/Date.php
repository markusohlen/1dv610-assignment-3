<?php

namespace model;

/**
 * Data structure for date
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

        var_dump(__CLASS__ . " : " . __LINE__);
        var_dump($year, $month, $day);
        
        return "$year-$month-$day";
    }
}
