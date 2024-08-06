<?php
if (!isset($_SESSION['authenticated'])) {
    $_SESSION['status'] = "Please Login To Acces";
    header("Location: /login");
    exit(0);
    if (!isset($_SESSION['is_verified']) || $_SESSION['is_verified'] === false) {
        $_SESSION['status'] = "You need to verify your account first!";
        header("Location: /verifyuser");
        exit();
    }
} else {
    # code...
}


