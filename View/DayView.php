<?php

namespace view;

class DayView
{
    private static $save = "DayView::SaveNote";
    private static $title = "DayView::Title";
    private static $note = "DayView::Note";

    private $cd;
    private $sm;

    private $date;

    public function __construct(\model\CalendarDatabase $cd, \model\SessionModel $sm)
    {
        $this->cd = $cd;
        $this->sm = $sm;
    }
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

    public function wantsToSaveNote()
    {
        return isset($_POST[self::$save]);
    }

    public function getNote()
    {
        return new \model\Note($this->getRequestTitle(), $this->getRequestNote());
    }

    public function setDate(\model\Date $date)
    {
        $this->date = $date;
    }

	/**
    * Generate HTML code for the day
    
	* @return String - A html page as a string
	*/
    private function generateDayHTML() : string 
    {
        try {
            $note = $this->cd->fetchNote($this->sm->getUserID(), $this->date->getDate());
            $title = $note->getTitle();
            $content = $note->getNote();
        } catch (\Throwable $th) {
            $title = "";
            $content = "";
        }
        
        // var_dump($note);
        
		return "
        <h1>Day</h1>

        <form method='post'>
            <label for='" . self::$title . "'>Title</p>
            <input name='" . self::$title . "' id='" . self::$title . "' type='text' value='$title'>
            <br>
            <label for='" . self::$note . "'>Note</p>
            <textarea rows='4' cols='50' id='" . self::$note . "' name='" . self::$note . "' placeholder='Enter text here...'>$content</textarea>
            <br>
            <input type='submit' name='" . self::$save . "' value='Save'>
        </form>
        
        <div class='day'>

        </div>
		";
    }

    private function getRequestTitle(): string
    {
        return $_POST[self::$title];
    }

    private function getRequestNote(): string
    {
        return $_POST[self::$note];
    }
}
