<?php

namespace model;

class SessionModel
{
    private static $userID = __CLASS__ . "::UserID";

    public function __construct()
    {
        // Checks if session is acticve
        assert(session_status() === PHP_SESSION_ACTIVE);
    }

    public function setUserID(int $id) : void 
    {
        $_SESSION[self::$userID] = $id;
    }

    public function setLoggedOut() : void 
    {
        $_SESSION[self::$userID] = 0;
    }

    public function getIsLoggedIn() : bool 
    {
        if (isset($_SESSION[self::$userID]) && $_SESSION[self::$userID] !== 0) 
        {
            return true;
        }
        return false;
    }
}
