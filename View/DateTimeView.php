<?php

namespace view;

class DateTimeView 
{
	/**
    * Generate HTML code for the time
    *
	* @return String - A html page as a string
	*/
	public function show() : string 
	{
		date_default_timezone_set("Europe/Stockholm");

		$dayInWeek = date("l");
		$day = date("jS");
		$month = date("F");
		$year = date("o");
		$currentTime = date("H:i:s");

		$timeString = "$dayInWeek, the $day of $month $year, The time is $currentTime";

		return '<p>' . $timeString . '</p>';
	}
}