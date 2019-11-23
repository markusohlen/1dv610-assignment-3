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
            $date = $this->view->getDate();

            $this->db->saveNote($note, $this->sm->getUserID(), $date->getDate());
            // Header("Location: " . \config\Constants::loginURL);
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

    public function updateNote() : void
    {
        try {
            $note = $this->dayView->getNote();
            $date = $this->view->getDate();

            //                                                                  true if you want to update
            $this->db->saveNote($note, $this->sm->getUserID(), $date->getDate(), true);
            // Header("Location: " . \config\Constants::loginURL);
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
        $this->view->setMonth();
    }
}