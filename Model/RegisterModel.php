<?php

namespace model;

class RegisterModel {
    public function passwordsMatch(string $password, string $passwordRepeat)
    {
        if ($password !== $passwordRepeat)
        {
            throw new PasswordsDoNotMatchException();
        }
    }

    public function usernameIsValid(string $username) 
    {
        if (strlen($username) < 3) 
        {
            throw new UsernameTooShortException();
        } 
    }

    public function passwordsIsTooShort(string $password, string $passwordRepeat) 
    {
        if (strlen($password) < 6 && strlen($passwordRepeat) < 6) 
        {
            throw new PasswordsTooShortException();
        }
    }
}
