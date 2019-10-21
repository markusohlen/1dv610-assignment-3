<?php

namespace controller;

class CalendarController
{
    private $view;

    public function __construct(\view\CalendarView $cv)
    {
        $this->view = $cv;
    }

    public function run() : void
    {
        if ($this->view->wantsToChangeCalendarDate() === true)
        {
            $this->doChangeDate();
        }
    }

    private function doChangeDate() : void
    {
        $date = $this->view->getMonth();
        $this->view->setMonth($date);
    }
}