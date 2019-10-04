<?php

namespace model;

class DatabaseModel {
    private static $username = 'username';
    private static $password = 'password';

    // Database
    private static $dbhost = 'DB_HOST';
    private static $dbuser = 'DB_USERNAME';
    private static $dbpassword = 'DB_PASSWORD';
    private static $dbtable = 'DB_NAME';

    private function fetchUsers() {
        $users = array();

        $conn = new \mysqli($_ENV[self::$dbhost], $_ENV[self::$dbuser], $_ENV[self::$dbpassword], $_ENV[self::$dbtable]);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 
        
        $sql = "SELECT * FROM assignment3";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $obj2 = new \stdClass();
                $obj2->username = $row["username"];
                $obj2->password = $row["password"];
                array_push($users, $obj2);
            }
        }

        $conn->close();
        
        return $users;
    }

    public function findUser($username) {
        foreach ($this->fetchUsers() as $user) {         
            if ($user->username === $username) {
                return true;
            }
        }
        return false;
    }
}