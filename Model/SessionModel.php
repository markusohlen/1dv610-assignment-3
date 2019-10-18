<?php

namespace model;

class SessionModel
{
    private static $isLoggedIn = "SessionModel::IsLoggedIn";

    public function setLoggedIn() : void 
    {
        $_SESSION[self::$isLoggedIn] = true;
    }

    public function setLoggedOut() : void 
    {
        $_SESSION[self::$isLoggedIn] = false;
    }

    public function getLoggedIn() : bool 
    {
        if (isset($_SESSION[self::$isLoggedIn]) && $_SESSION[self::$isLoggedIn] === true) 
        {
            return true;
        }
        return false;
    }
}
