<?php

namespace model;

class UserModel
{
    private $username;
    private $password;
    private $passwordRepeat;

    public function __construct($username, $password, $passwordRepeat)
    {
        $this->username = $username;
        $this->password = $password;
        $this->passwordRepeat = $passwordRepeat;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function passwordsMatch()
    {
        if ($this->password !== $this->passwordRepeat)
        {
            throw new PasswordsDoNotMatchException();
        }
    }

    public function usernameIsValid () {
        if (strlen($this->username) < 3) {
            throw new UsernameTooShortException();
        } 
    }

    public function passwordsIsTooShort () {
        if (strlen($this->password) < 6 && strlen($this->passwordRepeat) < 6) {
            throw new PasswordsTooShortException();
        }
    }
}
