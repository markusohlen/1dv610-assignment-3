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
	public function response() : string {
        $response = $this->generateCalendarHTML();

        $response .= $this->generateLogoutButtonHTML();

		return $response;
	}

	/**
	* Generate HTML code on the output buffer for the logout button
	* @return string BUT writes to standard output!
	*/
	private function generateLogoutButtonHTML() : string {
		return '
			
		';
	}
	
	/**
	* Generate HTML code on the output buffer for the logout button
	* @return , BUT writes to standard output!
	*/
	private function generateCalendarHTML() : string {
		$currentUsername = "";

		return '
		<h1>Calendar</h1>
		';
	}
}
