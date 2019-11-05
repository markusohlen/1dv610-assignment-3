<?php

namespace view;

class DayView
{
    private static $changeDate = "DayView::SaveNote";

    /**
	 * Creates a HTML view view
     * 
     * @return String - A html page as a string
	 */
    public function response() : string 
    {
        $response = $this->generateDayHTML();

		return $response;
    }
    
    public function wantsToChangeDayDate(): bool
    {
        if (isset($_POST[self::$changeDate]))
        {
            return true;
        }
        return false;
    }

	/**
    * Generate HTML code for the day
    
	* @return String - A html page as a string
	*/
    private function generateDayHTML() : string 
    {
		return "
        <h1>Day</h1>

        <form method='post'>
            <label for='title'>Title</p>
            <input name='title' id='title' type='text'>
            <br>
            <label for='note'>Note</p>
            <textarea rows='4' cols='50' id='note' name='comment' placeholder='Enter text here...'></textarea>
            <br>
            <input type='submit' name='" . self::$changeDate . "' value='Save'>
        </form>
        
        <div class='day'>

        </div>
		";
    }
}
