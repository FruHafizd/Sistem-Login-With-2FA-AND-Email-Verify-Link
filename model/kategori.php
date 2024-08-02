<?php
include 'config/connection.php';

class Kategori 
{   
    private $conn;

    public function __construct()
    {
        $db = new Connection();
        $this->conn = $db->connectionDatabase();
    }

    public function getCategories()
    {
        $query = "SELECT * FROM kategori";
        $sth = $this->conn->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $sth->execute();
        return $sth;
    }
}
