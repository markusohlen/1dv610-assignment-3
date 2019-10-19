<?php

namespace model;

class DatabaseModel 
{
    private static $username = 'username';
    private static $password = 'password';

    // Database
    private static $dbhost = 'DB_HOST';
    private static $dbuser = 'DB_USERNAME';
    private static $dbpassword = 'DB_PASSWORD';
    private static $dbname = 'DB_NAME';
    private static $dbport = 'DB_PORT';
    private static $dbtable = 'DB_TABLE';

    private function fetchUsers() : array 
    {
        $users = array();

        $conn = new \mysqli(getenv(self::$dbhost), getenv(self::$dbuser), getenv(self::$dbpassword), getenv(self::$dbname), getenv(self::$dbport));
        
        if ($conn->connect_error) 
        {
            die("Connection failed: " . $conn->connect_error);
        } 
        
        $table = getenv(self::$dbtable);
        
        $sql = "SELECT * FROM $table";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) 
        {
            while($row = $result->fetch_assoc()) 
            {
                $username = $row[self::$username];
                $password = $row[self::$password];

                $userCred = new \model\User($username, $password);

                array_push($users, $userCred);
            }
        }

        $conn->close();
        
        return $users;
    }

    public function userExists($username) : bool 
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

    public function passwordMatch($username, $password) : bool 
    {
        $user = null;
        $users = $this->fetchUsers();

        foreach ($users as $u) 
        {
            if ($u->getUsername() === $username) 
            {
                $user = $u;
            }
        }

        if ($user === null) 
        {
            return false;
        }

        if ($user->getPassword() === $password) 
        {
            return true;
        }

        return false;
    }

    public function registerUser(string $username, string $password) : void 
    {
        $conn = new \mysqli(getenv(self::$dbhost), getenv(self::$dbuser), getenv(self::$dbpassword), getenv(self::$dbname), getenv(self::$dbport));
        
        if ($conn->connect_error) 
        {
            die("Connection failed: " . $conn->connect_error);
        } 
        
        $table = getenv(self::$dbtable);

        $sql = "INSERT INTO $table (username, password)
            VALUES ('$username', '$password')";
        
        $conn->query($sql);
        
        // if ($conn->query($sql) === TRUE) {
        //     echo "New record created successfully";
        // } else {
        //     echo "Error: " . $sql . "<br>" . $conn->error;
        // }

        $conn->close();
    }
}