<?php

namespace controller;

class CalendarController
{
    private $view;
    private $dayView;
    private $db;

    public function __construct(\view\CalendarView $cv, \view\DayView $dv, \model\CalendarDatabase $db)
    {
        $this->view = $cv;
        $this->dayView = $dv;
        $this->db = $db;
    }

    public function saveNote() : void
    {
        try {
            $note = $this->dayView->getNote();
            $this->db->saveNote($note, "1", "2019-11-05");
        } 
        catch (\model\NoteTooShortException $e) 
        {
            var_dump($e->getMessage());
        }
        catch (\model\TitleTooShortException $e) 
        {
            var_dump($e->getMessage());
        }
    }

    public function doChangeDate() : void
    {
        $date = $this->view->getMonth();
        $this->view->setMonth($date);
    }
}