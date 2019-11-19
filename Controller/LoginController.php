<?php

namespace controller;

class LoginController
{
    private $view;
    private $model;
    private $dbModel;
    private $session;
    private $calendarController;

    public function __construct(\view\LoginView $lv, \model\DatabaseModel $dbm, \model\SessionModel $sm, \controller\CalendarController $cc)
    {
        $this->view = $lv;
        $this->model = new \model\LoginModel();
        $this->dbModel = $dbm;
        $this->session = $sm;
        $this->calendarController = $cc;
    }

    public function login() : void 
    {
        if ($this->session->usernameIsSet() === true)
        {
            $this->view->setNewlyRegisteredMessage();
        }
        if ($this->view->userPressedLogout() === true && $this->session->getIsLoggedIn() === true) 
        {
            $this->doLogout();
            return;
        }

        // Doesn't try to log in if the user hasn't pressed login yet
        if ($this->view->userPressedLogin() === false) 
        {
            return;
        }

        $this->doLogin();
    }

    private function doLogout() : void 
    {
        $this->view->setLogoutMessage();
        $this->session->setLoggedOut();
    }

    private function doLogin() : void
    {
        $user = $this->view->getUserCredentials();

        try 
        {
            $this->model->checkMissingUsername($user->getUsername());
            $this->model->checkMissingPassword($user->getPassword());

            $userToCompare = $this->dbModel->fetchUser($user->getUsername());

            $this->model->checkPasswordsMatch($user->getPassword(), $userToCompare->getPassword());

            $this->view->setWelcomeMessage();
            $id = $this->dbModel->fetchUserID($user->getUsername());
            $this->session->setUserID($id);
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
    }
}
