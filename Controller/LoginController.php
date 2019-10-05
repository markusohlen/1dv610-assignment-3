<?php

namespace controller;

class LoginController
{
    private $view;
    private $model;

    public function __construct($lv, $lm) {
        $this->view = $lv;
        $this->model = $lm;
    }

    public function login() {
        if ($this->view->userPressedLogin() === false || $this->view->userFilledInUsername() === false || $this->view->userFilledInPassword() === false) {
            return;
        }
        echo "PRESSED LOGIN";
    }
}
