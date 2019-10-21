<?php

namespace view;

class CalendarView
{
    private static $changeDate = "CalendarView::ChangeDate";
    private static $changeDateValue = "CalendarView::ChangeDate";
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

        // $response .= $this->generateLogoutButtonHTML();

		return $response;
    }
    
    public function wantsToChangeCalendarDate(): bool
    {
        return true;
    }

	/**
	* Generate HTML code on the output buffer for the logout button
	* @return , BUT writes to standard output!
	*/
    private function generateCalendarHTML() : string 
    {
        // $date = date("Y")."-".date("m");

        
         
        if (isset($_POST["date"]) === false)
        {
            $month = date("m");
            $date = date("Y")."-".date("m");
        }
        else
        {
            $month = $_POST["month"];
            $date = $_POST["date"];
        }

        if (isset($_POST[self::$changeDate]))
        {
            $month = $_POST["month"];
            $date = $_POST["date"];
            echo "SDADASDAS";
        }

        $days = $this->generateDays($month);

        var_dump($date);
        $monthSelector = $this->generateMonthSelector(date("m"));
		return "
        <h1>Calendar</h1>

        <form method='post'>
            <input type='month' value='$date' name='date' id=''>
            <select name='month'>
                $monthSelector
            </select>
            <input type='submit' name='" . self::$changeDate . "' value='Change date'>
        </form>
        
        <div class='calendar'>
            $days
        </div>
		";
    }
    
    private function generateDays($month): string
    {
        $m = "";

        $year = date("Y");
        
        $days = cal_days_in_month(CAL_GREGORIAN, (int)$month, (int)$year);

        for ($i = 0; $i < $days; $i++)
        {
            $d = $i + 1;
            $m .= "
                <a href='?year=$year&amp;month=$month&amp;day=$d'><div class='calDay'>$d</div></a>
            ";
        }

        return $m;
    }

    private function generateMonthSelector($month)
    {
        $ret = "";

        for ($i = 1; $i <= 12; $i++) 
        {
            $monthName = date("F", mktime(0, 0, 0, $i));
            $ret .= "<option value='$i' " . $this->chooseDefault($i, $month) . ">$monthName</option>";
        }
        return $ret;
    }

    private function chooseDefault($selectValue, $month)
    {
        if ((int)$selectValue === (int)$month)
        {
            return "selected='true'";
        }
    }
}
