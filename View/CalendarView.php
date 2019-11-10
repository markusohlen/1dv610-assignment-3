<?php

namespace view;

class CalendarView
{
    private static $changeDate = "CalendarView::ChangeDate";
    private static $selectMonth = "CalendarView::SelectMonth";
    private static $year = "year";
    private static $month = "month";
    private static $day = "day";

    private $currentMonth;

    /**
	 * Creates a HTML view view
     * 
     * @return String - A html page as a string
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

    public function wantsToShowDay(): bool
    {
        return isset($_GET[self::$day]);
    }

    public function getDate()
    {
        return new \model\Date($this->getRequestYear(), $this->getRequestMonth(), $this->getRequestDay());
    }

    private function getMonth() : string
    {
        if (isset($_POST[self::$selectMonth]))
        {
            return $_POST[self::$selectMonth];
        }
        return date("m");
    }

    public function setMonth() : void
    {
        $month = $this->getMonth();
        if (isset($month))
        {
            $this->currentMonth = $month;
        }
    }

	/**
    * Generate HTML code for the calendar
    
	* @return String - A html page as a string
	*/
    private function generateCalendarHTML() : string 
    {
        $this->checkMonth();

        $days = $this->generateDays();

        $monthSelector = $this->generateMonthSelector();

		return "
        <h1>Calendar</h1>

        <form method='post'>
            <select name='" . self::$selectMonth . "'>
                $monthSelector
            </select>
            <input type='submit' name='" . self::$changeDate . "' value='Change date'>
        </form>
        
        <div class='calendar'>
            $days
        </div>
		";
    }

    private function getRequestYear(): string
    {
        return $_GET[self::$year];
    }

    private function getRequestMonth(): string
    {
        return $_GET[self::$month];
    }

    private function getRequestDay(): string
    {
        return $_GET[self::$day];
    }

    private function checkMonth() : void
    {
        if ($this->currentMonth === null)
        {
            $this->currentMonth = date("m");
        }
    }
    
    private function generateDays(): string
    {
        $m = "";

        $year = date("Y");
        
        $days = cal_days_in_month(CAL_GREGORIAN, (int)$this->currentMonth, (int)$year);

        for ($i = 0; $i < $days; $i++)
        {
            $d = $i + 1;
            $m .= "
                <a href='?" . self::$year . "=$year&amp;" . self::$month . "=$this->currentMonth&amp;" . self::$day . "=$d'><div class='calDay'>$d</div></a>
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
            $ret .= "<option value='$i' " . $this->chooseDefault($i, $this->currentMonth) . ">$monthName</option>";
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
