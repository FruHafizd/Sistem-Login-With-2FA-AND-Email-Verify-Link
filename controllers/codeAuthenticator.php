<?php
session_start();
use lfkeitel\phptotp\Totp;
use lfkeitel\phptotp\Base32;
include('../config/connection.php');
require '../vendor/autoload.php';

class CodeAuthenticator 
{
    private $conn;

    public function __construct()
    {
        $db = new Connection();
        $this->conn = $db->connectionDatabase();
    }

    public function generateSecretKey()
    {
        return Base32::encode(random_bytes(16)); 
    }

    public function generateTotpKey()
    {
        if (isset($_POST['generate_totp_key'])) {
            $email = $_SESSION['auth_user']['email'];
            $secret_key = $this->generateSecretKey();

            $query = "UPDATE users SET secret_key = :secret_key WHERE email = :email";
            $stmt = $this->conn->prepare($query);
            $result = $stmt->execute([
                'secret_key' => $secret_key,
                'email' => $email
            ]);

            if ($result) {
                $_SESSION['status'] = "TOTP Secret Key generated successfully.";
                $_SESSION['totp_secret'] = $secret_key;
                header("Location: /dashboard");
                exit();
            } else {
                $_SESSION['status'] = "Failed to generate TOTP Secret Key";
                header("Location: /dashboard");
                exit();
            }
        }
    }

    private function getSecretKey()
    {
        $email = $_SESSION['auth_user']['email'];
        
        $query = "SELECT secret_key FROM users WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->execute(['email' => $email]);
    
        // Ambil hasil
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Pastikan hasil tidak kosong
        return $result ? $result['secret_key'] : null;
    }

    public function createTotpCode()
    {   
        $secret = $this->getSecretKey();
        
        // Cek jika secret key ada
        if ($secret) {
            // Decode secret key dari Base32
            $base32SecretKey = Base32::decode($secret);

            // Inisialisasi objek Totp dengan secret key yang didekode
            $totp = new Totp('sha1', 0, 30); // Algoritma, timestamp, dan interval

            // Generate TOTP code
            $totpCode = $totp->generateToken($base32SecretKey);

            return $totpCode;
        } else {
            echo "Secret key tidak ditemukan.";
            return null;
        }
    }

    public function getTotpCodeUser()
    {
        $secretKey = $this->getSecretKey();

        return $this->createTotpCode($secretKey);
    }




}

$codeAuthen = new CodeAuthenticator();
$codeAuthen->generateTotpKey(); // Ganti nama metode jika perlu
$codeAuthen->createTotpCode();
