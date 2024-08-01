<?php
session_start(); // Pastikan session_start() dipanggil
include('../config/connection.php');
include('phpMailer.php');

// Debugging: Periksa apakah variabel sesi diatur
var_dump($_SESSION['username'], $_SESSION['email'], $_SESSION['verify_token']);

// Periksa apakah semua variabel sesi diatur
if (isset($_SESSION['username']) && isset($_SESSION['email']) && isset($_SESSION['verify_token'])) {
    $username = $_SESSION['username'];
    $email = $_SESSION['email'];
    $verify_token = $_SESSION['verify_token'];

    // Debugging: Tampilkan nilai variabel untuk memastikan semuanya benar
    echo "Username: $username, Email: $email, Verify Token: $verify_token";

    $code = new PhpMailerUser();
    $code->sendVerifyEmail($username, $email, $verify_token);
} else {
    // // Debugging: Tampilkan pesan jika variabel sesi tidak ditemukan
    // echo "Error: Verification information not found.";

    // // Redirect to registration page or handle the error
    // $_SESSION['status'] = "Error: Verification information not found.";
    // header("Location: ../../resource/views/login.php");
    // exit();
}
?>
