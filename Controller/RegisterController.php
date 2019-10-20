<?php

namespace controller;

class RegisterController {
    private $view;
    private $model;
    private $dbModel;

    private $hasException = false;
    private $user;

    public function __construct($rv, $dbm) {
        $this->view = $rv;
        $this->model = new \model\RegisterModel();
        $this->dbModel = $dbm;
    }

    public function start() {
        if ($this->view->userPressedRegister() === false) {
            return;
        }

        $this->register();
    }

    private function register()
    {
        $this->user = $this->view->getUserCredentials();
        
        $this->checkShortUserCredentials();
        $this->checkUserExists();
        $this->checkPasswordsMatch();

        if ($this->hasException === false)
        {
            $this->dbModel->registerUser($this->user->getUsername(), $this->user->getPassword());
        }
    }

    private function checkShortUserCredentials()
    {
        try 
        {
            $this->model->checkUsernameLength($this->user->getUsername());
        } 
        catch (\model\UsernameTooShortException $e) 
        {
            $this->hasException = true;
            $this->view->setInvalidUsernameMessage();
        }
        
        try 
        {
            $this->model->checkPasswordLength($this->user->getPassword());
        } 
        catch (\model\PasswordTooShortException $e) 
        {
            $this->hasException = true;
            $this->view->setPasswordTooShortMessage();
        }
    }

    private function checkUserExists()
    {
        try 
        {
            if ($this->dbModel->userExists($this->user->getUsername()) === true)
            {
                throw new \model\UserAlreadyExistsException();
            }
        } 
        catch (\model\UserAlreadyExistsException $e) 
        {
            $this->hasException = true;
            $this->view->setUsernameExistsMessage();
        }
    }

    private function checkPasswordsMatch()
    {
        try 
        {
            $this->model->passwordsMatch($this->user->getPassword(), $this->user->getPasswordRepeat());
        } 
        catch (\model\PasswordsDoNotMatchException $e) 
        {
            $this->hasException = true;
            $this->view->setPasswordsDoNotMatchMessage();
        }
    }
}
