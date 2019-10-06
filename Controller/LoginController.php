<?php

namespace controller;

class LoginController
{
    private $view;
    private $model;
    private $dbModel;

    public function __construct($lv, $lm, $dbm) {
        $this->view = $lv;
        $this->model = $lm;
        $this->dbModel = $dbm;
    }

    public function login() : void {
        if ($this->view->userPressedLogin() === false) {
            return;
        }

        if ($this->view->userFilledInCredentials() === false) {
            $this->view->generateMissingCredentialsMessage();
            return;
        }

        $username = $this->view->getRequestUsername();
        $password = $this->view->getRequestPassword();
        
        if ($this->dbModel->userExists($username) === true && $this->dbModel->passwordMatch($username, $password) == true) {
            $this->doLogin();
        } else {
            $this->view->generateIncorrectCredentialsMessage();
            return;
        }
    }

    private function doLogin() : void {
        echo "HITTADE ANVÄNDARE!<br>";
        echo "RÄTT LÖSEN OCKSÅ!";
    }
}
