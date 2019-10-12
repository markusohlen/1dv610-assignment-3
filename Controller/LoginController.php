<?php

namespace controller;

class LoginController
{
    private $view;
    private $model;
    private $dbModel;
    private $session;

    public function __construct($lv, $lm, $dbm, $sm) {
        $this->view = $lv;
        $this->model = $lm;
        $this->dbModel = $dbm;
        $this->session = $sm;
    }

    public function start() : void {
        echo "SADASDASDASDASDASD";
        if ($this->view->userPressedLogout() === true && $this->session->getLoggedIn() === true) {
            $this->doLogout();
            return;
        }

        if ($this->view->userPressedLogin() === false) {
            return;
        }

        if ($this->view->userFilledInCredentials() === false) {
            $this->view->setMissingCredentialsMessage();
            return;
        }

        $username = $this->view->getRequestUsername();
        $password = $this->view->getRequestPassword();
        
        if ($this->dbModel->userExists($username) === true && $this->dbModel->passwordMatch($username, $password) === true) {
            $this->doLogin();
        } else {
            $this->view->setIncorrectCredentialsMessage();
            return;
        }
    }

    private function doLogin() : void {
        $this->view->setWelcomeMessage();
        $this->session->setLoggedIn();
    }

    private function doLogout() : void {
        $this->view->setLogoutMessage();
        $this->session->setLoggedOut();
    }
}
