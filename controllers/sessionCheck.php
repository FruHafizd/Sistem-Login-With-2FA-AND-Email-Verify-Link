<?php


include('phpMailer.php');

if (isset($_SESSION['auth_user']['username']) && isset($_SESSION['auth_user']['email']) && isset($_SESSION['auth_user']['verify_token'])) {
    $username = $_SESSION['auth_user']['username'];
    $email = $_SESSION['auth_user']['email'];
    $verify_token = $_SESSION['auth_user']['verify_token'];

    $code = new PhpMailerUser();
    $code->sendVerifyEmail($username, $email, $verify_token);
} elseif (isset($_SESSION['register']['username']) && isset($_SESSION['register']['email']) && isset($_SESSION['register']['verify_token'])) {
    $username = $_SESSION['register']['username'];
    $email = $_SESSION['register']['email'];
    $verify_token = $_SESSION['register']['verify_token'];

    $code = new PhpMailerUser();
    $code->sendVerifyEmail($username, $email, $verify_token);
} else {
    // Redirect to login page or handle the error
    $_SESSION['status'] = "Error: Verification information not found.";
    header("Location: /login");
    exit();
}
