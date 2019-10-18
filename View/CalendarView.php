<?php

namespace view;

class CalendarView
{
    public function wantsToShowCalendarPage(): bool
    {
        echo "SADASDSAD";
        return true;
    }
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

	/**
	* Generate HTML code on the output buffer for the logout button
	* @return , BUT writes to standard output!
	*/
    private function generateCalendarHTML() : string 
    {
		$days = $this->generateDays();
		return "
        <h1>Calendar</h1>
        <form method='get'>
            <input type='month' name='' id=''>
        </form>
        
        $days
		";
    }
    
    private function generateDays(): string
    {
        $m = "";

        $month = date("m");
        $year = date("Y");
        
        $days = cal_days_in_month(CAL_GREGORIAN, (int)$month, (int)$year);

        for ($i = 0; $i < $days; $i++)
        {
            $d = $i + 1;
            $m .= "<div style='height: 100px; width: 150px; background-color: #f0f8ff; margin: 5px; float: left;'>$d</div>";
        }
        return $m;
    }
}
