<?php

namespace model;

class SessionModel
{
    private static $isLoggedIn = __CLASS__ . "::IsLoggedIn";

    public function __construct()
    {
        assert(session_status() === PHP_SESSION_ACTIVE);
    }

    public function setLoggedIn() : void 
    {
        $_SESSION[self::$isLoggedIn] = true;
    }

    public function setLoggedOut() : void 
    {
        $_SESSION[self::$isLoggedIn] = false;
    }

    public function getIsLoggedIn() : bool 
    {
        if (isset($_SESSION[self::$isLoggedIn]) && $_SESSION[self::$isLoggedIn] === true) 
        {
            return true;
        }
        return false;
    }
}
