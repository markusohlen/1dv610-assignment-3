<?php

namespace controller;

class MainController
{
    private $lv;
    private $rv;
    private $dtv;
    private $v;

    private $lc;
    private $rc;

    private $sm;
    private $dm;

    public function __construct()
    {
        $this->cv = new \view\CalendarView();
        $this->lv = new \view\LoginView($this->cv);
        $this->rv = new \view\RegisterView();
        $this->dtv = new \view\DateTimeView();
        $this->v = new \view\LayoutView();
        

        $this->sm = new \model\SessionModel();
        $this->dm = new \model\DatabaseModel();

        $this->lc = new \controller\LoginController($this->lv, $this->dm, $this->sm);
        
        $this->rc = new \controller\RegisterController($this->rv, $this->dm);
    }


    public function renderView() : void
    {
        $view = $this->decideView();
        $controller = $this->decideController($view);

        $this->runController($controller);

        $this->v->render($this->sm->getLoggedIn(), $this->dtv, $view);
    }


    private function runController($controller)
    {
        $controller->start();
    }


    private function decideView()
    {
        if ($this->rv->pressedRegister())
        {
            return $this->rv;
        }
        // else if ($this->cv->wantsToShowCalendarPage() === true && $this->sm->getLoggedIn() === true)
        // {
        //     return $this->cv;
        // }
        else
        {
            return $this->lv;
        }
    }


    private function decideController($view)
    {
        if ($view instanceof \view\RegisterView)
        {
            return $this->rc;
        }
        else
        { 
            return $this->lc;
        }
    }
}
