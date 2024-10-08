<?php
require_once __DIR__  .'/../config/connection.php';
session_start();

class Verify
{   
    private $conn;

    public function __construct() 
    {
        $db = new Connection();
        $this->conn = $db->connectionDatabase();
    }


    // public function verifyToken()
    // {
    //     if (isset($_GET['token'])) {
    //         $token = $_GET['token'];
    
    //         // Query untuk memeriksa token verifikasi
    //         $verify_query = "SELECT verify_token, verify_status FROM users WHERE verify_token = :token LIMIT 1";
    //         $stmt = $this->conn->prepare($verify_query);
    //         $stmt->bindParam(':token', $token, PDO::PARAM_STR);
    //         $stmt->execute();

    //         if ($stmt->rowCount() > 0) {
    //             $row = $stmt->fetch(PDO::FETCH_ASSOC);

    //             if ($row['verify_status'] == "0") {
    //                 $clicked_token = $row['verify_token'];
                    
    //                 // Query untuk memperbarui status verifikasi
    //                 $update_query = "UPDATE users SET verify_status = '1' WHERE verify_token = :token LIMIT 1";
    //                 $update_stmt = $this->conn->prepare($update_query);
    //                 $update_stmt->bindParam(':token', $clicked_token, PDO::PARAM_STR);
    //                 $update_result = $update_stmt->execute();

    //                 if ($update_result) {
    //                     $_SESSION['status'] = "Your Account has been verified Successfully";
    //                     header("Location: /login");
    //                     exit(0);
    //                 } else {
    //                     $_SESSION['status'] = "Verification Failed!";
    //                     header("Location: /login");
    //                     exit(0);
    //                 }

    //             } else {
    //                 $_SESSION['status'] = "Email Already Verified Please Login";
    //                 header("Location: /login");
    //                 exit(0);
    //             }
    //         } else {
    //             $_SESSION['status'] = "This Token does not Exist";
    //             header("Location: /login");
    //             exit(0);
    //         }

    //     } else {
    //         $_SESSION['status'] = "Not Allowed";
    //         header("Location: /login");
    //         exit(0);
    //     }
    // }

    public function verifyUser()
    {   
        $token = $_GET['token'];
        $query = "SELECT * FROM users WHERE verify_token = :token LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':token', $token, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $_SESSION['is_verified'] = true; // Update status verifikasi dalam session
            $_SESSION['status'] = "Your account has been verified!";
            header("Location: /login");
            exit();
        } else {
            $_SESSION['status'] = "Invalid verification token!";
            header("Location: /verifyuser");
            exit();
        }
    }


}

$verify = new Verify();
// $verify->verifyToken();
$verify->verifyUser();