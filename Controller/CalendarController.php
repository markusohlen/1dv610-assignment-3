<?php

namespace controller;

class CalendarController
{
    private $view;
    private $dv;
    private $db;
    private $sm;

    public function __construct(\view\CalendarView $cv, \view\DayView $dv, \model\CalendarDatabase $db, \model\SessionModel $sm)
    {
        $this->view = $cv;
        $this->dv = $dv;
        $this->db = $db;
        $this->sm = $sm;
    }

    public function saveNote(bool $wantsToUpdate) : void
    {
        try {
            $note = $this->dv->getNote();
            
            $date = $this->view->getDate();

            $this->db->saveNote($note, $this->sm->getUserID(), $date->getDate(), $wantsToUpdate);
            Header("Location: " . \config\Constants::loginURL);
        }
        catch (\model\TitleTooShortException $e) 
        {
            $this->dv->setTooShortTitleMessage();
        }
        catch (\model\NoteTooShortException $e) 
        {
            $this->dv->setTooShortNoteMessage();
        }
    }

    public function doChangeDate() : void
    {
        $this->view->setMonth();
    }
}