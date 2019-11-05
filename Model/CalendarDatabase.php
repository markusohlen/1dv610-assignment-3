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

    public function saveNote($note) : void 
    {
        $title = $note->getTitle();
        $note2 = $note->getNote();

        $conn = $this->createConnection();
        
        $this->checkConnectionError($conn);
        
        $table = getenv(self::$dbtable);

        $sql = "INSERT INTO $table (title, note, ownerID, date)
            VALUES ('$title', '$note2', '1', '2019-11-05')";
        
        $conn->query($sql);

        $conn->close();
    }

    public function fetchNotes() : array 
    {
        $notes = array();

        $conn = $this->createConnection();

        $this->checkConnectionError($conn); 
        
        $table = getenv(self::$dbtable);
        
        $sql = "SELECT * FROM $table";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) 
        {
            while($row = $result->fetch_assoc()) 
            {
                $title = $row[self::$title];
                $note = $row[self::$note];

                $note = new \model\Note($title, $note);

                array_push($notes, $note);
            }
        }

        $conn->close();
        
        return $notes;
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
