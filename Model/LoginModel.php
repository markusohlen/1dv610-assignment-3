<?php

namespace model;

class LoginModel
{
    public function checkMissingUsername(string $username)
    {
        if (strlen($username) === 0) // Empty
        {
            throw new MissingUsernameException();
        }
    }

    public function checkMissingPassword(string $password)
    {
        if (strlen($password) === 0) // Empty
        {
            throw new MissingPasswordException();
        }
    }
}
