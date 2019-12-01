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

    public function saveEvent(\model\Event $event, $userID, string $date, bool $wantsToUpdate = false) : void 
    {
        $conn = $this->createConnection();
        
        $this->checkConnectionError($conn);
        
        $sql = $this->getQuery($event, $userID, $date, $wantsToUpdate);
        
        $conn->query($sql);

        $conn->close();
    }

    public function fetchEvent($userID, $date) : \model\Event
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

            $event = new \model\Event($item[self::$title], $item[self::$note]);
            
            $conn->close();
        
            return $event;
        }

        throw new \model\EventNotFoundException();
        
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

    private function getQuery(\model\Event $event, $userID, string $date, bool $wantsToUpdate) : string
    {
        $title = $event->getTitle();
        $note = $event->getNote();

        $table = getenv(self::$dbtable);

        $dbTitle = self::$title;
        $dbNote = self::$note;
        $dbOwnerID = self::$ownerID;
        $dbDate = self::$date;

        if ($wantsToUpdate === true)
        {
            return "UPDATE $table
                SET $dbTitle = '$title', $dbNote = '$note'
                WHERE $dbOwnerID = '$userID' AND $dbDate = '$date'";
        }
        else
        {
            return "INSERT INTO $table ($dbTitle, $dbNote, $dbOwnerID, $dbDate)
                VALUES ('$title', '$note', '$userID', '$date')";
        }
    }
}
