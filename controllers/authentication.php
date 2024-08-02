<?php
session_start();

if (!isset($_SESSION['authenticated'])) {
    $_SESSION['status'] = "Please Login To Acces";
    header("Location: /login");
    exit(0);
} else {
    # code...
}
