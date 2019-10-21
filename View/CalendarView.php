<?php

namespace view;

class CalendarView
{
    private static $changeDate = "CalendarView::ChangeDate";
    private static $monthPost = "CalendarView::Month";

    private $month;

    /**
	 * Create HTTP response
	 *
	 * Should be called after a login attempt has been determined
	 *
	 * @return string BUT writes to standard output and cookies!
	 */

    public function response() : string 
    {
        $response = $this->generateCalendarHTML();

		return $response;
    }
    
    public function wantsToChangeCalendarDate(): bool
    {
        if (isset($_POST[self::$changeDate]))
        {
            return true;
        }
        return false;
    }

    public function getMonth() : string
    {
        if (isset($_POST[self::$monthPost]))
        {
            return $_POST[self::$monthPost];
        }
        return date("m");
    }

    public function setMonth(string $month) : void
    {
        if (isset($month))
        {
            $this->month = $month;
        }
    }

	/**
	* Generate HTML code on the output buffer for the logout button
	* @return , BUT writes to standard output!
	*/
    private function generateCalendarHTML() : string 
    {
        $this->checkMonth();

        $days = $this->generateDays();

        $monthSelector = $this->generateMonthSelector();

		return "
        <h1>Calendar</h1>

        <form method='post'>
            <select name='" . self::$monthPost . "'>
                $monthSelector
            </select>
            <input type='submit' name='" . self::$changeDate . "' value='Change date'>
        </form>
        
        <div class='calendar'>
            $days
        </div>
		";
    }

    private function checkMonth() : void
    {
        if ($this->month === null)
        {
            $this->month = date("m");
        }
    }
    
    private function generateDays(): string
    {
        $m = "";

        $year = date("Y");
        
        $days = cal_days_in_month(CAL_GREGORIAN, (int)$this->month, (int)$year);

        for ($i = 0; $i < $days; $i++)
        {
            $d = $i + 1;
            $m .= "
                <a href='?year=$year&amp;month=$this->month&amp;day=$d'><div class='calDay'>$d</div></a>
            ";
        }

        return $m;
    }

    private function generateMonthSelector() : string
    {
        $ret = "";

        for ($i = 1; $i <= 12; $i++) 
        {
            $monthName = date("F", mktime(0, 0, 0, $i));
            $ret .= "<option value='$i' " . $this->chooseDefault($i, $this->month) . ">$monthName</option>";
        }
        return $ret;
    }

    private function chooseDefault($selectValue, $month) : string
    {
        if ((int)$selectValue === (int)$month)
        {
            return "selected='true'";
        }
        return '';
    }
}
