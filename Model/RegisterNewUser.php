<?php

namespace model;

/**
 * Read only data structure for registrating a new user
 */
class RegisterNewUser
{
    private $username;
    private $password;
    private $passwordRepeat;

    public function __construct(string $username, string $password, string $passwordRepeat)
    {
        $this->username = $username;
        $this->password = $password;
        $this->passwordRepeat = $passwordRepeat;
    }

    public function getUsername() : string
    {
        return $this->username;
    }

    public function getPassword() : string
    {
        return $this->password;
    }

    public function getPasswordRepeat() : string
    {
        return $this->passwordRepeat;
    }
}
