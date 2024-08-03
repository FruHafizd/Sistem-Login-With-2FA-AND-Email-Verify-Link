<?php


include('phpMailer.php');

// var_dump($_SESSION['auth_user']['username']);



if (isset($_SESSION['auth_user']['username']) && isset($_SESSION['auth_user']['email']) && isset($_SESSION['auth_user']['verify_token'])) {
    $username = $_SESSION['auth_user']['username'];
    $email = $_SESSION['auth_user']['email'];
    $verify_token = $_SESSION['auth_user']['verify_token'];

    $code = new PhpMailerUser();
    $code->sendVerifyEmail($username, $email, $verify_token);
} else {
    // Redirect to login page or handle the error
    $_SESSION['status'] = "Error: Verification information not found.";
    // header("Location: /login");
    // exit();
}
