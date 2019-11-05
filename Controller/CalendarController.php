<?php

namespace controller;

class CalendarController
{
    private $view;
    private $dayView;
    private $db;
    private $sm;

    public function __construct(\view\CalendarView $cv, \view\DayView $dv, \model\CalendarDatabase $db, \model\SessionModel $sm)
    {
        $this->view = $cv;
        $this->dayView = $dv;
        $this->db = $db;
        $this->sm = $sm;
    }

    public function saveNote() : void
    {
        try {
            $note = $this->dayView->getNote();
            $date = $this->dayView->getDate();
            var_dump($date);
            $this->db->saveNote($note, $this->sm->getUserID(), $date->getDate());
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