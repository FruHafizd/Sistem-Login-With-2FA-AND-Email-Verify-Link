<?php
session_start(); // Memulai sesi jika belum dimulai

// Periksa apakah ID pengguna dikirim
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    // Tentukan direktori sesi jika menggunakan file-based session storage
    $sessionSavePath = session_save_path();
    
    if ($sessionSavePath) {
        // Scan file sesi
        $files = glob($sessionSavePath . '/sess_*');
        
        foreach ($files as $file) {
            // Membaca file sesi
            $sessionId = basename($file, '.php');
            session_id($sessionId);
            session_start();
            
            // Jika sesi pengguna cocok dengan ID yang dikirimkan dan bukan sesi saat ini
            if (isset($_SESSION['auth_user']['user_id']) && $_SESSION['auth_user']['user_id'] == $id && session_id() !== session_id()) {
                session_destroy(); // Hapus sesi
                unlink($file); // Hapus file sesi
                break; // Keluar setelah sesi ditemukan dan dihapus
            }
        }
    } else {
        echo 'Direktori sesi tidak ditemukan.<br>';
    }
    
    // Redirect ke halaman yang relevan setelah logout
    header('Location: /listaccount');
    exit();
} else {
    echo 'ID akun tidak ditemukan.';
}
?>
