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

    public function saveEvent(bool $wantsToUpdate) : void
    {
        try {
            $event = $this->dv->getEvent();
            
            $date = $this->view->getDate();

            $this->db->saveEvent($event, $this->sm->getUserID(), $date->getDate(), $wantsToUpdate);
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