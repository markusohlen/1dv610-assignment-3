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

    public function fetchUser($username) : \model\User
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

                $userCred = new \model\User($username, $password);

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

    private function checkConnectionError($conn)
    {
        if ($conn->connect_error) 
        {
            die("Connection failed: " . $conn->connect_error . "<br>Please try again later or contact an administrator");
        } 
    }
}