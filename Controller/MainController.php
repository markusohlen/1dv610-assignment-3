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
        $this->cv = new \view\CalendarView();
        $this->lv = new \view\LoginView($this->cv);
        $this->rv = new \view\RegisterView();
        $this->dtv = new \view\DateTimeView();
        $this->v = new \view\LayoutView($this->dtv);
        $this->dv = new \view\DayView();

        $this->sm = new \model\SessionModel();
        $this->dm = new \model\DatabaseModel();
        $this->cd = new \model\CalendarDatabase();

        $this->cc = new \controller\CalendarController($this->cv, $this->dv, $this->cd);
        $this->lc = new \controller\LoginController($this->lv, $this->dm, $this->sm, $this->cc);
        $this->rc = new \controller\RegisterController($this->rv, $this->dm);
    }

    public function renderView() : void
    {
        var_dump($this->dv->wantsToSaveNote());
        // var_dump($_POST);
        // var_dump($_GET);
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
            var_dump($this->dv->wantsToSaveNote());
            $this->cc->saveNote();
            $this->v->render(true, $this->dv);
        }
        else if ($this->sm->getIsLoggedIn() === true && $this->cv->wantsToShowDay() === true)
        {
            $this->v->render(true, $this->dv);
        }
        else
        {
            $this->lc->login();
            // var_dump($_GET);
            $this->v->render($this->sm->getIsLoggedIn(), $this->lv);
            
        }
    }
}
