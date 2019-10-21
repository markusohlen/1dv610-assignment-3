<?php

namespace controller;

class MainController
{
    // Views
    private $lv;
    private $rv;
    private $dtv;
    private $v;

    // Controllers
    private $lc;
    private $rc;
    private $cc;

    // Models
    private $sm;
    private $dm;
    private $cm;

    public function __construct()
    {
        $this->cv = new \view\CalendarView();
        $this->lv = new \view\LoginView($this->cv);
        $this->rv = new \view\RegisterView();
        $this->dtv = new \view\DateTimeView();
        $this->v = new \view\LayoutView($this->dtv);

        $this->sm = new \model\SessionModel();
        $this->dm = new \model\DatabaseModel();
        $this->cm = new \model\CalendarModel();

        $this->cc = new \controller\CalendarController($this->cv, $this->cm);
        $this->lc = new \controller\LoginController($this->lv, $this->dm, $this->sm, $this->cc);
        $this->rc = new \controller\RegisterController($this->rv, $this->dm);
    }

    public function renderView() : void
    {
        if ($this->v->userWantsToShowRegisterForm())
        {
            $this->rc->register();
            $this->v->render($this->sm->getIsLoggedIn(), $this->rv);
        }
        else
        {
            $this->lc->login();
            $this->cc->run();
            $this->v->render($this->sm->getIsLoggedIn(), $this->lv);
            
        }
    }
}
