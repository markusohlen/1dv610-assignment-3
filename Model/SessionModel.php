<?php

namespace model;

class SessionModel
{
    private static $userID = __CLASS__ . "::UserID";
    private static $username = __CLASS__ . "::Username";
    private static $month = __CLASS__ . "::Month";

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

    public function getUserID() : int
    {
        return $_SESSION[self::$userID];
    }

    public function getIsLoggedIn() : bool 
    {
        if (isset($_SESSION[self::$userID]) && $_SESSION[self::$userID] !== 0) 
        {
            return true;
        }
        return false;
    }

    public function setUsername(string $username) : void
    {
        $_SESSION[self::$username] = $username;
    }

    public function getUsername() : string
    {
        return $_SESSION[self::$username];
    }

    public function unsetUsername() : void
    {
        unset($_SESSION[self::$username]);
    }

    public function usernameIsSet() : bool
    {
        return isset($_SESSION[self::$username]);
    }

    // Month
    public function setMonth(string $month) : void
    {
        $_SESSION[self::$month] = $month;
    }

    public function getMonth() : string
    {
        return $_SESSION[self::$month];
    }

    public function monthIsSet() : bool
    {
        return isset($_SESSION[self::$month]);
    }
}
