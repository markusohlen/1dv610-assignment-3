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

    public function __construct()
    {
        $this->lv = new \view\LoginView();
        $this->rv = new \view\RegisterView();
        $this->dtv = new \view\DateTimeView();
        $this->v = new \view\LayoutView();

        $this->sm = new \model\SessionModel();

        $this->lc = new \controller\LoginController($this->lv,
        new \model\LoginModel(),
        new \model\DatabaseModel(),
        new \model\SessionModel());
        $this->rc = new \controller\RegisterController($this->rv,
        new \model\RegisterModel(),
        new \model\DatabaseModel());
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
        else if (false) 
        {
            echo "Hello from login";
        }
        else
        {
            return $this->lv;
        }
    }

    private function decideController($view)
    {
        if ($view instanceof $this->lv)
        {
            return $this->lc;
        }
        else if ($view instanceof $this->rv) 
        {
            return $this->rc;
        }
        else
        {
            return "FEL";
        }
    }
}
