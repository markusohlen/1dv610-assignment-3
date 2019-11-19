<?php

namespace controller;

class RegisterController {
    private $view;
    private $dbModel;
    private $session;

    // If anything is wrong with the credentials
    private $hasException = false;
    private $user;

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
            Header("Location: /1dv610-assignment-3");
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
    }

    private function checkCredentials(\model\RegisterNewUser $user) : void
    {
        $user->checkUsernameLength();
        $user->checkPasswordLength();

        if ($this->dbModel->userExists($user->getUsername()) === true)
        {
            throw new \model\UserAlreadyExistsException();
        }

        $user->passwordsMatch();
    }
}
