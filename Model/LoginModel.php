<?php

namespace model;

class LoginModel
{
    public function checkMissingUsername(string $username) : void
    {
        if (strlen($username) === 0) // Empty
        {
            throw new MissingUsernameException();
        }
    }

    public function checkMissingPassword(string $password) : void
    {
        if (strlen($password) === 0) // Empty
        {
            throw new MissingPasswordException();
        }
    }

    
    public function checkPasswordsMatch(string $password, string $passwordFromDB) : void
    {
        if ($password !== $passwordFromDB)
        {
            throw new InvalidCredentialsException();
        }
    }
}
