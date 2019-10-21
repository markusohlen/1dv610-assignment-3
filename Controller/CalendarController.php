<?php

namespace controller;

class CalendarController
{
    private $view;
    private $model;

    public function __construct(\view\CalendarView $cv, \model\CalendarModel $cm)
    {
        $this->view = $cv;
        $this->model = $cm;
    }

    public function run()
    {
        if ($this->view->wantsToChangeCalendarDate() === true)
        {
            $this->doChangeDate();
        }
    }

    private function doChangeDate()
    {
        $date = $this->view->getMonth();
        $this->view->setMonth($date);
    }
}