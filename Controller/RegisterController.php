<?php

namespace controller;

class RegisterController {
    private $view;
    private $model;
    private $dbModel;

    private $username;
    private $password;
    private $passwordRepeat;

    public function __construct($rv, $rm, $dbm) {
        $this->view = $rv;
        $this->model = $rm;
        $this->dbModel = $dbm;
    }

    public function register() {
        if ($this->view->userPressedRegister() === false) {
            return;
        }

        // if ($this->view->userFilledInCredentials() === false) {
        //     // $this->view->setMissingCredentialsMessage();
        //     return;
        // }

        $this->setCredentials();

        if ($this->hasInvalidCredentials() === true) {
            return;
        }

        $this->dbModel->registerUser($this->username, $this->password);
    }

    private function hasInvalidCredentials() {
        $hasInvalidCreddentials = false;
        if ($this->model->usernameIsValid($this->username) === false) {
            $this->view->setInvalidUsernameMessage();
            $hasInvalidCreddentials = true;
        }

        if ($this->model->passwordsIsTooShort($this->password, $this->passwordRepeat)) {
            $this->view->setPasswordTooShortMessage();
            $hasInvalidCreddentials = true;
        }

        if ($this->dbModel->userExists($this->username)) {
            $this->view->setUsernameExistsMessage();
            $hasInvalidCreddentials = true;
        }

        if ($this->model->passwordsMatch($this->password, $this->passwordRepeat) === false) {
            $this->view->setPasswordsDoNotMatchMessage();
            $hasInvalidCreddentials = true;
        }

        return $hasInvalidCreddentials;
    }

    private function setCredentials() {
        $this->username = $this->view->getRequestUsername();
        $this->password = $this->view->getRequestPassword();
        $this->passwordRepeat = $this->view->getRequestPasswordRepeat();
    }
}
