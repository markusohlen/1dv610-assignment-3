<?php

namespace model;

class DatabaseModel {
    private static $username = 'username';
    private static $password = 'password';

    // Database
    private static $dbhost = 'DB_HOST';
    private static $dbuser = 'DB_USERNAME';
    private static $dbpassword = 'DB_PASSWORD';
    private static $dbname = 'DB_NAME';
    private static $dbport = 'DB_PORT';
    private static $dbtable = 'DB_TABLE';

    private function fetchUsers() : array {
        $users = array();

        // $conn = new \mysqli($_ENV[self::$dbhost], $_ENV[self::$dbuser], $_ENV[self::$dbpassword], $_ENV[self::$dbname], $_ENV[self::$dbport]);
        $conn = new \mysqli(getenv(self::$dbhost), getenv(self::$dbuser), getenv(self::$dbpassword), getenv(self::$dbname), getenv(self::$dbport));
        
        
        
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 
        
        // $table = $_ENV[self::$dbtable];
        $table = getenv(self::$dbtable);
        $sql = "SELECT * FROM $table";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $userCred = new \stdClass();
                $userCred->username = $row[self::$username];
                $userCred->password = $row[self::$password];
                array_push($users, $userCred);
            }
        }

        $conn->close();
        
        return $users;
    }

    public function userExists($username) : bool {
        foreach ($this->fetchUsers() as $user) {         
            if ($user->username === $username) {
                return true;
            }
        }
        return false;
    }

    public function passwordMatch($username, $password) : bool {
        $user = null;
        $users = $this->fetchUsers();

        foreach ($users as $u) {
            if ($u->username === $username) {
                $user = $u;
            }
        }

        if ($user === null) {
            return false;
        }

        if ($user->password === $password) {
            return true;
        }

        return false;
    }
}