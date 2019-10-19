<?php

namespace controller;

class RegisterController {
    private $view;
    private $model;
    private $dbModel;

    private $username;
    private $password;
    private $passwordRepeat;

    public function __construct($rv, $dbm) {
        $this->view = $rv;
        $this->model = new \model\RegisterModel();
        $this->dbModel = $dbm;
    }

    public function start() {
        if ($this->view->userPressedRegister() === false) {
            return;
        }

        try 
        {
            $user = $this->view->getUserCredentials();

            if ($this->dbModel->userExists($user->getUsername()) === true)
            {
                throw new \model\UserAlreadyExistsException();
            }

            $user->usernameIsValid();
            $user->passwordsIsTooShort();
            $user->passwordsMatch();

            $this->dbModel->registerUser($user->getUsername(), $user->getPassword());
        }
        catch (\model\PasswordsDoNotMatchException $e) 
        {
            $this->view->setPasswordsDoNotMatchMessage();
        } 
        catch (\model\UsernameTooShortException $e) 
        {
            $this->view->setInvalidUsernameMessage();
        } 
        catch (\model\PasswordsTooShortException $e) 
        {
            $this->view->setPasswordTooShortMessage();
        } 
        catch (\model\UserAlreadyExistsException $e) 
        {
            $this->view->setUsernameExistsMessage();
        }
    }
}
