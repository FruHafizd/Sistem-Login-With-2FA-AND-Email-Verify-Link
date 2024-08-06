<?php
session_start();

require_once __DIR__  .'/../config/connection.php';
class LoginAttempt {
    private $conn;
    private $maxAttempts = 5;
    private $lockoutTime = 300; // dalam detik (misalnya, 5 menit)

    public function __construct() {
        $db = new Connection();
        $this->conn = $db->connectionDatabase();
    }

    public function isBlocked($email, $ipAddress) {
        $stmt = $this->conn->prepare('SELECT COUNT(*) FROM login_attempts WHERE (email = :email OR ip_address = :ip_address) AND attempt_time > DATE_SUB(NOW(), INTERVAL :lockoutTime SECOND)');
        $stmt->execute([
            ':email' => $email,
            ':ip_address' => $ipAddress,
            ':lockoutTime' => $this->lockoutTime
        ]);
        return $stmt->fetchColumn() >= $this->maxAttempts;
    }

    public function addAttempt($email, $ipAddress) {
        $stmt = $this->conn->prepare('INSERT INTO login_attempts (email, ip_address) VALUES (:email, :ip_address)');
        $stmt->execute([
            ':email' => $email,
            ':ip_address' => $ipAddress
        ]);
    }

    public function clearAttempts($email, $ipAddress) {
        $stmt = $this->conn->prepare('DELETE FROM login_attempts WHERE email = :email OR ip_address = :ip_address');
        $stmt->execute([
            ':email' => $email,
            ':ip_address' => $ipAddress
        ]);
    }
}
