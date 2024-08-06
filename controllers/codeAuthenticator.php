<?php
session_start();

use lfkeitel\phptotp\Totp;
use lfkeitel\phptotp\Base32;

require_once __DIR__  . '/../config/connection.php';
require __DIR__ . '/../vendor/autoload.php';

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
                $email = $_SESSION['auth_user']['email'];
                header("Location: /profile?id=" . $email);
                exit();
            } else {
                $_SESSION['status'] = "Failed to generate TOTP Secret Key";
                $email = $_SESSION['auth_user']['email'];
                header("Location: /profile?id=" . $email);

                exit();
            }
        }
    }

    public function getOtpAuthUrl($username, $issuer, $secret)
    {
        // Menghasilkan URL otpauth
        $url = "otpauth://totp/{$issuer}:{$username}?secret={$secret}&issuer={$issuer}";
        return $url;
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


    public function generateQR()
    {
        $secret_key = $this->getSecretKey();

        // Cek jika secret key ada
        if (!$secret_key) {
            echo "Secret key tidak ditemukan.";
            return;
        }

        $user = $_SESSION['auth_user']['username'];

        $otpauthUrl = $this->getOtpAuthUrl($user, 'Manajemen Inventaris', $secret_key);

        // Simpan URL otpauth ke sesi
        $_SESSION['otpauth_url'] = $otpauthUrl;

        // Debug URL
        // echo "OTP Auth URL: " . $otpauthUrl;
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
