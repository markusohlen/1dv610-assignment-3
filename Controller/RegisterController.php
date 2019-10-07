<?php

namespace controller;

class RegisterController {
    private $view;
    private $model;
    private $dbModel;

    public function __construct($rv, $rm, $dbm) {
        $this->view = $rv;
        $this->model = $rm;
        $this->dbModel = $dbm;
    }

    public function register() {
        echo "HELLO FROM REGISTERCONTROLLER";
    }
}
