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

        $this->cv = new \view\CalendarView();
        $this->lv = new \view\LoginView($this->cv);
        $this->rv = new \view\RegisterView();
        $this->dtv = new \view\DateTimeView();
        $this->v = new \view\LayoutView($this->dtv);
        $this->dv = new \view\DayView($this->cd, $this->sm);

        $this->cc = new \controller\CalendarController($this->cv, $this->dv, $this->cd, $this->sm);
        $this->lc = new \controller\LoginController($this->lv, $this->dm, $this->sm, $this->cc);
        $this->rc = new \controller\RegisterController($this->rv, $this->dm);
    }

    public function renderView() : void
    {
        if ($this->lv->userWantsToShowRegisterForm())
        {
            $this->rc->register();
            $this->v->render($this->sm->getIsLoggedIn(), $this->rv);
        }
        else if ($this->sm->getIsLoggedIn() === true && $this->cv->wantsToChangeCalendarDate() === true)
        {
            $this->cc->doChangeDate();
            
            $this->v->render(true, $this->cv);
        }
        else if ($this->sm->getIsLoggedIn() === true && $this->dv->wantsToSaveNote() === true)
        {
            $this->cc->saveNote();
            $this->v->render(true, $this->dv);
        }
        else if ($this->sm->getIsLoggedIn() === true && $this->cv->wantsToShowDay() === true)
        {
            $date = $this->cv->getDate();
            $this->dv->setDate($date);

            $this->v->render(true, $this->dv);
        }
        else
        {
            $this->lc->login();
            $this->v->render($this->sm->getIsLoggedIn(), $this->lv);
        }
    }
}
