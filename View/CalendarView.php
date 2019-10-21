<?php

namespace view;

class CalendarView
{
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
    
    public function wantsToShowCalendarPage(): bool
    {
        return true;
    }

	/**
	* Generate HTML code on the output buffer for the logout button
	* @return , BUT writes to standard output!
	*/
    private function generateCalendarHTML() : string 
    {
        $date = date("Y")."-".date("m");

        $days = $this->generateDays();
        
        // <form method='get'>
        //     <input type='month' value='$date' name='' id=''>
        //     <input type='submit' name='submit' value='Ändra datum'>
        // </form>
		return "
        <h1>Calendar</h1>
        
        
        <div class='calendar'>
            $days
        </div>
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
            $m .= "<a href='?year=$year&month=$month&day=$d'><div class='calDay'>$d</div></a>";
        }

        return $m;
    }
}
