<?php

namespace view;

class DayView
{
    private static $changeDate = "DayView::SaveNote";

    private $cd;
    private $sm;

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
        return isset($_POST[self::$changeDate]);
    }

    public function getNote()
    {
        return new \model\Note($this->getRequestTitle(), $this->getRequestNote());
    }

    public function getDate()
    {
        return new \model\Date($this->getRequestYear(), $this->getRequestMonth(), $this->getRequestDay());
    }

	/**
    * Generate HTML code for the day
    
	* @return String - A html page as a string
	*/
    private function generateDayHTML() : string 
    {
        try {
            $note = $this->cd->fetchNote($this->sm->getUserID(), $this->getDate()->getDate());
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
            <label for='title'>Title</p>
            <input name='title' id='title' type='text' value='$title'>
            <br>
            <label for='note'>Note</p>
            <textarea rows='4' cols='50' id='note' name='note' placeholder='Enter text here...'>$content</textarea>
            <br>
            <input type='submit' name='" . self::$changeDate . "' value='Save'>
        </form>
        
        <div class='day'>

        </div>
		";
    }

    private function getRequestYear(): string
    {
        return $_GET["year"];
    }

    private function getRequestMonth(): string
    {
        return $_GET["month"];
    }

    private function getRequestDay(): string
    {
        return $_GET["day"];
    }

    private function getRequestTitle(): string
    {
        return $_POST["title"];
    }

    private function getRequestNote(): string
    {
        return $_POST["note"];
    }
}
