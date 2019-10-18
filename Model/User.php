<?php

namespace model;

class User
{
    private $username;
    private $password;

    public function __construct($username, $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function checkMissingCredentials()
    {
        if (strlen($this->username) === 0)
        {
            throw new MissingUsernameException();
        }

        if (strlen($this->password) === 0)
        {
            throw new MissingPasswordException();
        }
    }
}
