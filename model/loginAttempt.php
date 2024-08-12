<?php
include __DIR__ . '/../config/connection.php';

class LoginAttempt 
{
    private $conn;

    public function __construct()
    {
        $db = new Connection();
        $this->conn = $db->connectionDatabase();
    }

    public function displayLog()
    {
        $query = "SELECT * FROM login_attempts";
        $sth = $this->conn->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $sth->execute();
        return $sth;
    }
}
