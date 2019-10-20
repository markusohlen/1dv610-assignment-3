<?php

namespace controller;

class RegisterController {
    private $view;
    private $model;
    private $dbModel;

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

            $this->model->usernameIsValid($user->getUsername());
            $this->model->passwordIsTooShort($user->getPassword());
            $this->model->passwordsMatch($user->getPassword(), $user->getPasswordRepeat());

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
