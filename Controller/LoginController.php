<?php

namespace controller;

class LoginController
{
    private $view;
    private $model;
    private $dbModel;
    private $session;
    private $calendarController;

    private $hasException = false;
    private $user;

    public function __construct($lv, $dbm, $sm, $cc) 
    {
        $this->view = $lv;
        $this->model = new \model\LoginModel();
        $this->dbModel = $dbm;
        $this->session = $sm;
        $this->calendarController = $cc;
    }

    public function login() : void 
    {
        if ($this->view->userPressedLogout() === true && $this->session->getIsLoggedIn() === true) 
        {
            $this->doLogout();
            return;
        }

        // Doesn't try to log in if the user hasn't pressed login yet
        if ($this->view->userPressedLogin() === false) 
        {
            return;
        }

        $this->doLogin();
    }

    private function doLogout() : void 
    {
        $this->view->setLogoutMessage();
        $this->session->setLoggedOut();
    }

    private function doLogin()
    {
        $this->user = $this->view->getUserCredentials();

        $this->checkMissingCredentials();
        $this->checkInvalidCredentials();

        if ($this->hasException === false)
        {
            $this->view->setWelcomeMessage();
            $this->session->setLoggedIn();
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
            $userToCompare = $this->dbModel->fetchUser($this->user->getUsername());

            $this->model->checkPasswordsMatch($this->user->getPassword(), $userToCompare->getPassword());
        }
        catch (\model\InvalidCredentialsException $e)
        {
            $this->hasException = true;
            $this->view->setIncorrectCredentialsMessage();
        }
    }
}
