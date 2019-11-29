<?php

namespace view;

class CalendarView
{
    private static $changeDate = "CalendarView::ChangeDate";
    private static $selectMonth = "CalendarView::SelectMonth";
    private static $year = "year";
    private static $month = "month";
    private static $day = "day";

    private $sm;

    public function __construct(\model\SessionModel $sm)
    {
        $this->sm = $sm;
    }

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

        $this->sm->setMonth($month);
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
        if ($this->sm->monthIsSet() === false)
        {
            $month = date("m");
            $this->sm->setMonth($month);
        }
    }
    
    private function generateDays(): string
    {
        $ret = "";

        $month = $this->sm->getMonth();

        $year = date("Y");
        
        $days = cal_days_in_month(CAL_GREGORIAN, (int)$this->sm->getMonth(), (int)$year);

        for ($i = 0; $i < $days; $i++)
        {
            $day = $i + 1;
            $ret .= "
                <a href='?" . self::$year . "=$year&amp;" . self::$month . "=$month&amp;" . self::$day . "=$day'><div class='calDay'>$day</div></a>
            ";
        }

        return $ret;
    }

    private function generateMonthSelector() : string
    {
        $ret = "";

        for ($i = 1; $i <= 12; $i++) 
        {
            // Generates the full name of a month ex. January
            $monthName = date("F", mktime(0, 0, 0, $i));
            $ret .= "<option value='$i' " . $this->chooseDefault($i, $this->sm->getMonth()) . ">$monthName</option>";
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
