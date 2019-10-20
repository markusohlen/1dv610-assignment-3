<?php

namespace controller;

class LoginController
{
    private $view;
    private $model;
    private $dbModel;
    private $session;

    private $hasException = false;
    private $user;

    public function __construct($lv, $dbm, $sm) 
    {
        $this->view = $lv;
        $this->model = new \model\LoginModel();
        $this->dbModel = $dbm;
        $this->session = $sm;
    }

    public function start() : void 
    {
        if ($this->view->userPressedLogout() === true && $this->session->getIsLoggedIn() === true) 
        {
            $this->doLogout();
            return;
        }

        if ($this->view->userPressedLogin() === false) 
        {
            return;
        }

        $this->login();
        
    }

    private function login()
    {
        $this->user = $this->view->getUserCredentials();

        $this->checkMissingCredentials();
        $this->checkInvalidCredentials();

        if ($this->hasException === false)
        {
            $this->doLogin();
        }
    }

    private function checkMissingCredentials()
    {
        try 
        {
            $this->model->checkMissingUsername($this->user->getUsername());
        }
        catch (\model\MissingUsernameException $e)  
        {
            $this->hasException = true;
            $this->view->setMissingUsernameMessage();
        }

        try 
        {
            $this->model->checkMissingPassword($this->user->getPassword());
        } 
        catch (\model\MissingPasswordException $e)
        {
            $this->hasException = true;
            $this->view->setMissingPasswordMessage();
        }
    }

    private function checkInvalidCredentials()
    {
        try 
        {
            if ($this->dbModel->userExists($this->user->getUsername()) === false)
            {
                throw new \model\InvalidCredentialsException();
            }

            if ($this->dbModel->passwordMatch($this->user->getUsername(), $this->user->getPassword()) === false)
            {
                throw new \model\InvalidCredentialsException();
            }
        }
        catch (\model\InvalidCredentialsException $e)
        {
            $this->hasException = true;
            $this->view->setIncorrectCredentialsMessage();
        }
    }

    private function doLogin() : void {
        $this->view->setWelcomeMessage();
        $this->session->setLoggedIn();
    }

    private function doLogout() : void {
        $this->view->setLogoutMessage();
        $this->session->setLoggedOut();
    }
}
