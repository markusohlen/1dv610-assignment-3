<?php

namespace model;

class RegisterModel 
{
    public function checkUsernameLength(string $username) : void
    {
        if (strlen($username) < \config\Constants::minUsernameLength) 
        {
            throw new UsernameTooShortException();
        } 
    }

    public function checkPasswordLength(string $password) : void
    {
        if (strlen($password) < \config\Constants::minPasswordLength) 
        {
            throw new PasswordTooShortException();
        }
    }

    public function passwordsMatch(string $password, string $passwordRepeat) : void
    {
        if ($password !== $passwordRepeat)
        {
            throw new PasswordsDoNotMatchException();
        }
    }
}
