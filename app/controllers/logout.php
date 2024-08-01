<?php

require 'userControllers.php';
$code = new UserControllers();
$code->logout();

session_start();

$_SESSION['status'] = "You have logged out successfully";

// Redirect to the login page
header("Location: ../../resource/views/login.php"); 



exit();