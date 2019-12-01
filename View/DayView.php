<?php

namespace view;

class DayView
{
    private static $save = "DayView::SaveEvent";
    private static $update = "DayView::UpdateEvent";
    private static $title = "DayView::Title";
    private static $note = "DayView::Note";

    private $cd;
    private $sm;

    private $date;
    private $message = "";

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

    public function wantsToSaveEvent()
    {
        return isset($_POST[self::$save]);
    }

    public function wantsToUpdateEvent()
    {
        return isset($_POST[self::$update]);
    }

    public function getEvent()
    {
        return new \model\Event($this->getRequestTitle(), $this->getRequestNote());
    }

    public function setDate(\model\Date $date)
    {
        $this->date = $date;
    }

    public function setTooShortTitleMessage() : void
    {
        $this->message .= "Title is too short, should be at least " . \config\Constants::minTitleLength . " characters long";
    }

    public function setTooShortNoteMessage() : void
    {
        $this->message .= "Note is too short, should be at least " . \config\Constants::minNoteLength . " characters long";
    }

	/**
    * Generate HTML code for the day
    *
	* @return String - A html page as a string
	*/
    private function generateDayHTML() : string 
    {
        $title = "";
        $content = "";
        
        try {
            $event = $this->cd->fetchEvent($this->sm->getUserID(), $this->date->getDate());

            $title = $event->getTitle();
            $content = $event->getNote();

            $saveButton = "<input type='submit' name='" . self::$update . "' value='Update'>";
        } 
        catch (\model\EventNotFoundException $e) 
        {
            $saveButton = "<input type='submit' name='" . self::$save . "' value='Save'>";
        }

        if ($this->wantsToSaveEvent() === true || $this->wantsToUpdateEvent() === true) 
        {
            $title = $this->getRequestTitle();
            $content = $this->getRequestNote();
        }

		return "
        <h1>Day</h1>

        <a href='" . \config\Constants::loginURL . "'>Back to calendar</a>
        <br>

        <p>" . $this->message . "</p>

        <form method='post'>
            <label for='" . self::$title . "'>Title</p>
            <input name='" . self::$title . "' id='" . self::$title . "' type='text' value='$title'>
            <br>
            <label for='" . self::$note . "'>Note</p>
            <textarea rows='4' cols='50' id='" . self::$note . "' name='" . self::$note . "'>$content</textarea>
            <br>
            $saveButton
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
