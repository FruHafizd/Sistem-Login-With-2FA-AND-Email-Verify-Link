<?php

session_start();

// Hapus semua data session
session_unset();

// Hancurkan session
session_destroy();

// Buat session baru untuk menampilkan pesan logout
session_start();
$_SESSION['status'] = "You have logged out successfully";

// Redirect ke halaman login
header("Location: /login");
exit();
?>
