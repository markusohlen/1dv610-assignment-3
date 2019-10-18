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
        // if ($this->view->userPressedRegister() === false) {
        //     return;
        // }

        // $this->setCredentials();

        // if ($this->hasInvalidCredentials() === true) {
        //     return;
        // }

        // $this->dbModel->registerUser($this->username, $this->password);
        if ($this->view->userPressedRegister() === false) {
            return;
        }

        try {
            $this->user = $this->view->getUserCredentials();

            $this->user->passwordsMatch();
            $this->user->usernameIsValid();
            $this->user->passwordsIsTooShort();

            if ($this->dbModel->userExists($this->user->getUsername()) === true)
            {
                throw new \model\UserAlreadyExistsException();
            }

        } catch (\model\PasswordsDoNotMatchException $e) {
            $this->view->setPasswordsDoNotMatchMessage();
        } catch (\model\UsernameTooShortException $e) {
            $this->view->setInvalidUsernameMessage();
        } catch (\model\PasswordsTooShortException $e) {
            $this->view->setPasswordTooShortMessage();
        } catch (\model\UserAlreadyExistsException $e) {
            $this->view->setUsernameExistsMessage();
        }
        
        $this->dbModel->registerUser($this->user);
    }
}
