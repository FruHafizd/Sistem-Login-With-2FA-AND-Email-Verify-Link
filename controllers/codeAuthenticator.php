<?php
session_start();
use lfkeitel\phptotp\Totp;
use lfkeitel\phptotp\Base32;
include('../config/connection.php');
require '../vendor/autoload.php';

class codeAuthenticator 
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

    public function codeAuthenticator()
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
                $_SESSION['status'] = "TOTP Secret Key generated successfully: " . $secret_key;
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
        var_dump($result);
    }

    public function createTotpCode()
    {   
        $secret = $this->getSecretKey();
        
        // Cek jika secret key ada
        if ($secret) {
            // Decode secret key dari Base32
            $base32SecretKey = Base32::decode($secret);

            // Inisialisasi objek Totp dengan secret key yang didekode
            $totp = new Totp($base32SecretKey);
            
            // Generate TOTP code
            $totpCode = $totp->generateToken($base32SecretKey); // Pastikan `generateToken()` adalah metode yang benar

            // Tampilkan kode dan secret key untuk debugging
            var_dump($totpCode);
            var_dump($secret); // Tampilkan secret key dalam format Base32
            var_dump($base32SecretKey); // Tampilkan secret key yang didekode
        } else {
            echo "Secret key tidak ditemukan.";
        }
    }















    
}

$codeAuthen = new codeAuthenticator;
$codeAuthen->codeAuthenticator();
$codeAuthen->createTotpCode();
