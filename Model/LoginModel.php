<?php

namespace model;

class LoginModel
{
    public function checkMissingCredentials(string $username, string $password)
    {
        if (strlen($username) === 0) // Empty
        {
            throw new MissingUsernameException();
        }

        if (strlen($password) === 0) // Empty
        {
            throw new MissingPasswordException();
        }
    }
}
