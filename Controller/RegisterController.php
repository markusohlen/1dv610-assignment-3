<?php

namespace controller;

class RegisterController {
    private $view;
    private $dbModel;

    // If anything is wrong with the credentials
    private $hasException = false;
    private $user;

    public function __construct(\view\RegisterView $rv, \model\DatabaseModel $dbm) {
        $this->view = $rv;
        $this->dbModel = $dbm;
    }

    public function register() : void
    {
        if ($this->view->userPressedRegister() === false) {
            return;
        }

        $this->doRegistration();
    }

    private function doRegistration() : void
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

    private function checkShortUserCredentials() : void
    {
        try 
        {
            $this->user->checkUsernameLength();
        } 
        catch (\model\UsernameTooShortException $e) 
        {
            $this->hasException = true;
            $this->view->setInvalidUsernameMessage();
        }
        
        try 
        {
            $this->user->checkPasswordLength();
        } 
        catch (\model\PasswordTooShortException $e) 
        {
            $this->hasException = true;
            $this->view->setPasswordTooShortMessage();
        }
    }

    private function checkUserExists() : void
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

    private function checkPasswordsMatch() : void
    {
        try 
        {
            $this->user->passwordsMatch();
        } 
        catch (\model\PasswordsDoNotMatchException $e) 
        {
            $this->hasException = true;
            $this->view->setPasswordsDoNotMatchMessage();
        }
    }
}
