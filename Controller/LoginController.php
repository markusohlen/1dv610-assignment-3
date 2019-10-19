<?php

namespace controller;

class LoginController
{
    private $view;
    private $model;
    private $dbModel;
    private $session;

    public function __construct($lv, $dbm, $sm) {
        $this->view = $lv;
        $this->model = new \model\LoginModel();
        $this->dbModel = $dbm;
        $this->session = $sm;
    }

    public function start() : void {
        if ($this->view->userPressedLogout() === true && $this->session->getLoggedIn() === true) 
        {
            $this->doLogout();
            return;
        }

        if ($this->view->userPressedLogin() === false) 
        {
            return;
        }

        try 
        {
            $user = $this->view->getUserCredentials();
            $this->model->checkMissingCredentials($user->getUsername(), $user->getPassword());

            if ($this->dbModel->userExists($user->getUsername()) === false)
            {
                throw new \model\InvalidCredentialsException();
            }

            if ($this->dbModel->passwordMatch($user->getUsername(), $user->getPassword()) === false)
            {
                throw new \model\InvalidCredentialsException();
            }

            $this->doLogin();
        } 
        catch (\model\MissingUsernameException $e) 
        {
            $this->view->setMissingUsernameMessage();
        }
        catch (\model\MissingPasswordException $e)
        {
            $this->view->setMissingPasswordMessage();
        }
        catch (\model\InvalidCredentialsException $e)
        {
            $this->view->setIncorrectCredentialsMessage();
        }

        // if ($this->dbModel->userExists($username) === true && $this->dbModel->passwordMatch($username, $password) === true) {
        //     $this->doLogin();
        // } else {
        //     $this->view->setIncorrectCredentialsMessage();
        //     return;
        // }
        // var_dump($user);
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
