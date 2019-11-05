<?php

namespace model;

class CalendarDatabase
{
    private static $title = 'title';
    private static $note = 'note';

    // Database
    private static $dbhost = 'DB_HOST';
    private static $dbuser = 'DB_USERNAME';
    private static $dbpassword = 'DB_PASSWORD';
    private static $dbname = 'DB_NAME';
    private static $dbport = 'DB_PORT';
    private static $dbtable = 'DB_CALENDAR_TABLE';

    public function saveNote(\model\Note $note, $userID, $date) : void 
    {
        $title = $note->getTitle();
        $note2 = $note->getNote();

        $conn = $this->createConnection();
        
        $this->checkConnectionError($conn);
        
        $table = getenv(self::$dbtable);

        $sql = "INSERT INTO $table (title, note, ownerID, date)
            VALUES ('$title', '$note2', '$userID', '$date')";
        
        $conn->query($sql);

        $conn->close();
    }

    public function fetchNote($userID, $date) : \model\Note
    {
        $conn = $this->createConnection();

        $this->checkConnectionError($conn); 
        
        $table = getenv(self::$dbtable);
        
        $sql = "SELECT * FROM $table
            WHERE ownerID = '$userID' && date = '$date'";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) 
        {
            $item = $result->fetch_assoc();
            $note = new \model\Note($item["title"], $item["note"]);
        }

        $conn->close();
        
        return $note;
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
