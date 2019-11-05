<?php

namespace controller;

class CalendarController
{
    private $view;
    private $dayView;

    public function __construct(\view\CalendarView $cv, \view\DayView $dv)
    {
        $this->view = $cv;
        $this->dayView = $dv;
    }

    public function saveNote() : void
    {
        try {
            $note = $this->dayView->getNote();
        } catch (\Exception $e) {
            //throw $th;
        }
        
        var_dump($note);
    }

    public function doChangeDate() : void
    {
        $date = $this->view->getMonth();
        $this->view->setMonth($date);
    }
}