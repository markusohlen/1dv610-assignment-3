<?php

namespace model;

class DatabaseModel 
{
    private static $username = 'username';
    private static $password = 'password';
    private static $userID = 'id';

    // Database
    private static $dbhost = 'DB_HOST';
    private static $dbuser = 'DB_USERNAME';
    private static $dbpassword = 'DB_PASSWORD';
    private static $dbname = 'DB_NAME';
    private static $dbport = 'DB_PORT';
    private static $dbtable = 'DB_TABLE';

    public function userExists(string $username) : bool 
    {
        foreach ($this->fetchUsers() as $user) 
        {         
            if ($user->getUsername() === $username) 
            {
                return true;
            }
        }
        return false;
    }

    public function fetchUser(string $username) : \model\User
    {
        $users = $this->fetchUsers();

        foreach ($users as $user) 
        {         
            if ($user->getUsername() === $username) 
            {
                return $user;
            }
        }
        throw new InvalidCredentialsException();
    }

    public function registerUser(string $username, string $password) : void 
    {
        $conn = $this->createConnection();
        
        $this->checkConnectionError($conn);
        
        $table = getenv(self::$dbtable);

        $sql = "INSERT INTO $table (" . self::$username . ", " . self::$password . ")
            VALUES ('$username', '$password')";
        
        $conn->query($sql);

        $conn->close();
    }

    public function fetchUserID($username) : int
    {
        $id = null;
        $conn = $this->createConnection();

        $this->checkConnectionError($conn); 
        
        $table = getenv(self::$dbtable);
        
        $sql = "SELECT " . self::$userID . " FROM $table
            WHERE " . self::$username . " = '$username'";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) 
        {
            $id = $result->fetch_assoc()[self::$userID];
        }

        $conn->close();
        
        return $id;
    }

    private function fetchUsers() : array 
    {
        $users = array();

        $conn = $this->createConnection();

        $this->checkConnectionError($conn); 
        
        $table = getenv(self::$dbtable);
        
        $sql = "SELECT * FROM $table";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) 
        {
            while($row = $result->fetch_assoc()) 
            {
                $username = $row[self::$username];
                $password = $row[self::$password];
                $userID = $row[self::$userID];

                $userCred = new \model\User($username, $password, $userID);

                array_push($users, $userCred);
            }
        }

        $conn->close();
        
        return $users;
    }

    private function createConnection() : \mysqli
    {
        $host = getenv(self::$dbhost);
        $user = getenv(self::$dbuser);
        $password = getenv(self::$dbpassword);
        $dbName = getenv(self::$dbname);
        $port = getenv(self::$dbport);

        return new \mysqli($host, $user, $password, $dbName, $port);
    }

    private function checkConnectionError(\mysqli $conn) : void
    {
        if ($conn->connect_error) 
        {
            die("Connection failed: " . $conn->connect_error . "<br>Please try again later or contact an administrator");
        } 
    }
}