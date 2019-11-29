<?php

namespace controller;

class MainController
{
    // Views
    private $lv;
    private $rv;
    private $dtv;
    private $v;
    private $dv;

    // Controllers
    private $lc;
    private $rc;
    private $cc;

    // Models
    private $sm;
    private $dm;
    private $cd;

    public function __construct()
    {
        $this->sm = new \model\SessionModel();
        $this->dm = new \model\DatabaseModel();
        $this->cd = new \model\CalendarDatabase();

        $this->cv = new \view\CalendarView($this->sm);
        $this->lv = new \view\LoginView($this->cv, $this->sm);
        $this->rv = new \view\RegisterView();
        $this->dtv = new \view\DateTimeView();
        $this->v = new \view\LayoutView($this->dtv);
        $this->dv = new \view\DayView($this->cd, $this->sm);

        $this->cc = new \controller\CalendarController($this->cv, $this->dv, $this->cd, $this->sm);
        $this->lc = new \controller\LoginController($this->lv, $this->dm, $this->sm, $this->cc);
        $this->rc = new \controller\RegisterController($this->rv, $this->dm, $this->sm);
    }

    public function renderView() : void
    {
        if ($this->sm->getIsLoggedIn() === true)
        {
            $this->doLoggedInChecks();
        }
        else if ($this->lv->userWantsToShowRegisterForm())
        {
            $this->showRegisterForm();
        }
        else
        {
            $this->login();
        }
    }

    private function doLoggedInChecks() : void
    {
        if ($this->cv->wantsToChangeCalendarDate() === true)
        {
            $this->changeCalendarDate();
        }
        else if ($this->dv->wantsToSaveNote() === true)
        {
            $wantsToUpdate = false;
            $this->saveNote($wantsToUpdate);
        }
        else if ($this->dv->wantsToUpdateNote() === true)
        {
            $wantsToUpdate = true;
            $this->saveNote($wantsToUpdate);
        }
        else if ($this->cv->wantsToShowDay() === true)
        {
            $this->showDay();
        }
        else
        {
            $this->login();
        }
    }

    private function showRegisterForm() : void
    {
        $this->rc->register();
        $this->v->render($this->sm->getIsLoggedIn(), $this->rv);
    }

    private function changeCalendarDate() : void
    {
        $this->cc->doChangeDate();
        $this->v->render(true, $this->lv);
    }

    private function saveNote(bool $wantsToUpdate) : void
    {
        $this->setDate();

        $this->cc->saveNote($wantsToUpdate);
        $this->v->render(true, $this->dv);
    }

    private function showDay() : void
    {
        $this->setDate();

        $this->v->render(true, $this->dv);
    }

    private function login()
    {
        $this->lc->login();
        $this->v->render($this->sm->getIsLoggedIn(), $this->lv);
    }

    private function setDate()
    {
        $date = $this->cv->getDate();
        $this->dv->setDate($date);
    }
}
