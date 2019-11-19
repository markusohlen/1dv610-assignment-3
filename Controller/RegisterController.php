<?php

namespace controller;

class RegisterController {
    private $view;
    private $dbModel;
    private $session;

    public function __construct(\view\RegisterView $rv, \model\DatabaseModel $dbm, \model\SessionModel $sm) {
        $this->view = $rv;
        $this->dbModel = $dbm;
        $this->session = $sm;
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
        try {
            $user = $this->view->getUserCredentials();
        
            $this->checkCredentials($user);

            $this->dbModel->registerUser($user->getUsername(), $user->getPassword());

            $this->session->setUsername($user->getUsername());

            Header("Location: " . \config\Constants::loginURL);
        }
        catch (\model\UsernameTooShortException $e) 
        {
            $this->view->setInvalidUsernameMessage();
        }
        catch (\model\PasswordTooShortException $e) 
        {
            $this->view->setPasswordTooShortMessage();
        }
        catch (\model\UserAlreadyExistsException $e) 
        {
            $this->view->setUsernameExistsMessage();
        }
        catch (\model\PasswordsDoNotMatchException $e) 
        {
            $this->view->setPasswordsDoNotMatchMessage();
        }
        catch (\model\MissingAllCredentialsException $e) 
        {
            $this->view->setInvalidUsernameMessage();
            $this->view->setPasswordTooShortMessage();
        }
        catch (\model\InvalidCharactersException $e) 
        {
            $this->view->setInvalidCharactersMessage();
        }
    }

    private function checkCredentials(\model\RegisterNewUser $user) : void
    {
        $user->checkUsernameLength();
        $user->checkPasswordLength();
        $user->checkInvalidCharcters();

        if ($this->dbModel->userExists($user->getUsername()) === true)
        {
            throw new \model\UserAlreadyExistsException();
        }

        $user->passwordsMatch();
    }
}
