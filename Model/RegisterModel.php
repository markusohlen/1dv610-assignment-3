<?php

namespace model;

class RegisterModel {
    private static $minUsernameLength = 3;
    private static $minPasswordLength = 6;

    public function checkUsernameLength(string $username) 
    {
        if (strlen($username) < self::$minUsernameLength) 
        {
            throw new UsernameTooShortException();
        } 
    }

    public function checkPasswordLength(string $password) 
    {
        if (strlen($password) < self::$minPasswordLength) 
        {
            throw new PasswordTooShortException();
        }
    }

    public function passwordsMatch(string $password, string $passwordRepeat)
    {
        if ($password !== $passwordRepeat)
        {
            throw new PasswordsDoNotMatchException();
        }
    }
}
