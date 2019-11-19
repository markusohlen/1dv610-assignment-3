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
        // Empty username and password
        if (strlen($username) === 0 && strlen($password) === 0)
        {
            throw new MissingAllCredentialsException();
        }

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

    public function checkUsernameLength() : void
    {
        if (strlen($this->username) < \config\Constants::minUsernameLength) 
        {
            throw new UsernameTooShortException();
        } 
    }

    public function checkPasswordLength() : void
    {
        if (strlen($this->password) < \config\Constants::minPasswordLength) 
        {
            throw new PasswordTooShortException();
        }
    }

    public function checkInvalidCharcters() : void
    {
        if ($this->username !== strip_tags($this->username))
        {
            throw new InvalidCharactersException();
        }
    }

    public function passwordsMatch() : void
    {
        if ($this->password !== $this->passwordRepeat)
        {
            throw new PasswordsDoNotMatchException();
        }
    }
}
