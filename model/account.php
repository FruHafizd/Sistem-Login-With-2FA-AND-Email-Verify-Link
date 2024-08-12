<?php
include __DIR__ . '/../config/connection.php';

class Account 
{
    private $conn;

    public function __construct()
    {
        $db = new Connection();
        $this->conn = $db->connectionDatabase();
    }

    public function displayAccount()
    {
        $query = "SELECT * FROM users";
        $sth = $this->conn->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $sth->execute();
        return $sth;
    }
    
}
