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

    public function login() {
        if ($this->view->userPressedLogin() === false) {
            return;
        }

        if ($this->view->userFilledInCredentials() === false) {
            $this->view->generateMissingCredentialsMessage();
            return;
        }

        $username = $this->view->getRequestUsername();
        $password = $this->view->getRequestPassword();
        
        if ($this->dbModel->userExists($username) === true) {
            echo "HITTADE ANVÄNDARE!<br>";
            if ($this->dbModel->passwordMatch($username, $password)) {
                echo "RÄTT LÖSEN OCKSÅ!";
            }
        }
    }
}
