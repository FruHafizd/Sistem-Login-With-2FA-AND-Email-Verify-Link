<?php
session_start();
/**
 * 
 * Require files
 * 
 */
require_once __DIR__ . '/config/__init.php';
require_once __DIR__ . '/router/index.php';

/**
 * 
 * new instance of router
 * 
 */
$router = new Router();

/**
 * 
 * handle / route
 * 
 */
$router->get('/','index.php');
$router->get('/home','index.php');
$router->get('/dashboard','dashboard.php');
$router->get('/login','login.php');
$router->get('/register','register.php');
$router->get('/verifyuser','optionUsers.php');
$router->get('/resendemail','resend-email-verification.php');

$router->get('/barang','/PengelolaanBarang/index.php');
$router->get('/tambahBarang','/PengelolaanBarang/add.php');
$router->get('/ubahBarang','/PengelolaanBarang/update.php');

$router->get('/emailVerify','/auth/emailVerification.php');
$router->get('/authenticationApplication','/auth/codeAuthenticator.php');

// Pengecekan session sebelum mengaksesnya
if (isset($_SESSION['auth_user'])) {
    $email = $_SESSION['auth_user']['email']; // Ambil email dari session
    $token = $_SESSION['auth_user']['verify_token'];

    $router->get("/profile?id=" . $email, 'userProfile.php');
    $router->get('/changePassword?token=' . $token . '&email=' . $email, '/passwordReset/password-change.php');
} else {
    // Jika session belum di-set, arahkan ke halaman login
    $router->get("/profile", function() {
        header("Location: /login");
        exit();
    });

    $router->get("/changePassword", function() {
        header("Location: /login");
        exit();
    });
}

$router->get('/resetPassword','/passwordReset/password-reset.php');

