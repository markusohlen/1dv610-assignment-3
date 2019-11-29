<?php

namespace model;

class CalendarDatabase
{
    private static $title = 'title';
    private static $note = 'note';
    private static $ownerID = 'ownerID';
    private static $date = 'date';

    // Database
    private static $dbhost = 'DB_HOST';
    private static $dbuser = 'DB_USERNAME';
    private static $dbpassword = 'DB_PASSWORD';
    private static $dbname = 'DB_NAME';
    private static $dbport = 'DB_PORT';
    private static $dbtable = 'DB_CALENDAR_TABLE';

    public function saveNote(\model\Note $note, $userID, string $date, bool $wantsToUpdate = false) : void 
    {
        $conn = $this->createConnection();
        
        $this->checkConnectionError($conn);
        
        $sql = $this->getQuery($note, $userID, $date, $wantsToUpdate);
        
        $conn->query($sql);

        $conn->close();
    }

    public function fetchNote($userID, $date) : \model\Note
    {
        $conn = $this->createConnection();

        $this->checkConnectionError($conn); 
        
        $table = getenv(self::$dbtable);
        
        $dbOwnerID = self::$ownerID;
        $dbDate = self::$date;

        $sql = "SELECT * FROM $table
            WHERE $dbOwnerID = '$userID' AND $dbDate = '$date'";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) 
        {
            $item = $result->fetch_assoc();

            $note = new \model\Note($item[self::$title], $item[self::$note]);
            
            $conn->close();
        
            return $note;
        }

        throw new \model\NoteNotFoundException();
        
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
            die($conn->connect_error);
        } 
    }

    private function getQuery(\model\Note $note, $userID, string $date, bool $wantsToUpdate) : string
    {
        $title = $note->getTitle();
        $note2 = $note->getNote();

        $table = getenv(self::$dbtable);

        $dbTitle = self::$title;
        $dbNote = self::$note;
        $dbOwnerID = self::$ownerID;
        $dbDate = self::$date;

        if ($wantsToUpdate === true)
        {
            return "UPDATE $table
                SET $dbTitle = '$title', $dbNote = '$note2'
                WHERE $dbOwnerID = '$userID' AND $dbDate = '$date'";
        }
        else
        {
            return "INSERT INTO $table ($dbTitle, $dbNote, $dbOwnerID, $dbDate)
                VALUES ('$title', '$note2', '$userID', '$date')";
        }
    }
}
