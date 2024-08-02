<?php
include('../config/connection.php');
require('phpMailer.php');
session_start();

class UserControllers
{
    private $conn;
    private $username;
    private $email;
    private $verify_token;

    public function __construct()
    {
        $db = new Connection();
        $this->conn = $db->connectionDatabase();
    }

    public function register()
    {
        if (isset($_POST['register_btn'])) {
            $this->email = $_POST['email'];
            $password = $_POST['password'];
            $password_hashed = password_hash($password, PASSWORD_BCRYPT);
            $phone = $_POST['phone'];
            $this->username = $_POST['username'];
            $this->verify_token = md5(rand());

            // Prepare and execute statement to check if email already exists
            $check_email_query = "SELECT email FROM users WHERE email = :email LIMIT 1";
            $stmt = $this->conn->prepare($check_email_query);
            $stmt->execute(['email' => $this->email]);

            if ($stmt->rowCount() > 0) {
                $_SESSION['status'] = "Email Id Already Exists";
                header("Location: /register");
                exit();
            } else {
                // Prepare and execute statement to insert new user
                $query = "INSERT INTO users (username, email, password, phone, verify_token) VALUES (:username, :email, :password, :phone, :verify_token)";
                $stmt = $this->conn->prepare($query);
                $result = $stmt->execute([
                    'username' => $this->username,
                    'email' => $this->email,
                    'password' => $password_hashed,
                    'phone' => $phone,
                    'verify_token' => $this->verify_token
                ]);

                if ($result) {
                    $_SESSION['status'] = "Registration Successfully, Please Verify Your Account";
                    $_SESSION['username'] = $this->username;
                    $_SESSION['email'] = $this->email;
                    $_SESSION['verify_token'] = $this->verify_token;
                    header("Location: /verifyuser");
                    exit();
                } else {
                    $_SESSION['status'] = "Registration Failed";
                    header("Location: /register");
                    exit();
                }
            }
        }
    }

    public function login()
    {
        if (isset($_POST['login_now_btn'])) {
            if (!empty(trim($_POST['email'])) && !empty(trim($_POST['password']))) {
                $email = trim($_POST['email']);
                $password = trim($_POST['password']);

                // Cari pengguna berdasarkan email
                $login_query = "SELECT * FROM users WHERE email = :email LIMIT 1";
                $stmt = $this->conn->prepare($login_query);
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                $stmt->execute();

                if ($stmt->rowCount() > 0) {
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    $hashed_password = $row['password'];

                    // Verifikasi password
                    if (password_verify($password, $hashed_password)) {
                        if ($row["verify_status"] == "1") {
                            $_SESSION['authenticated'] = TRUE;
                            $_SESSION['auth_user'] = [
                                'user_id' => $row['id'],
                                'username' => $row['username'],
                                'phone' => $row['phone'],
                                'email' => $row['email'],
                            ];
                            $_SESSION['status'] = "You Are Logged In Successfully";
                            header("Location: /home");
                            exit(0);
                        } else {
                            $_SESSION['status'] = "Please Verify Your Account To Log In";
                            header("Location: /verifyuser");
                            exit(0);
                        }
                    } else {
                        $_SESSION['status'] = "Invalid Email Or Password";
                        header("Location: /login");
                        exit(0);
                    }
                } else {
                    $_SESSION['status'] = "Invalid Email Or Password";
                    header("Location: /login");
                    exit(0);
                }
            } else {
                $_SESSION['status'] = "All fields are Mandatory";
                header("Location: /login");
                exit(0);
            }
        }
    }

    public function logout()
    {
        if (isset($_SESSION['auth_user']['email'])) {
            $email = $_SESSION['auth_user']['email'];

            // Query untuk memeriksa status verifikasi
            $verify_query = "SELECT verify_token, verify_status FROM users WHERE email = :email LIMIT 1";
            $stmt = $this->conn->prepare($verify_query);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $clicked_token = $row['verify_token'];

                // Query untuk memperbarui status verifikasi
                $update_query = "UPDATE users SET verify_status = '0' WHERE email = :email LIMIT 1";
                $update_stmt = $this->conn->prepare($update_query);
                $update_stmt->bindParam(':email', $email, PDO::PARAM_STR);
                $update_result = $update_stmt->execute();

                if ($update_result) {
                    // Hapus semua variabel sesi
                    session_unset();
                    // Hancurkan sesi
                    session_destroy();
                    $_SESSION['status'] = "You have logged out successfully. Please verify your account again.";
                    header("Location: /login");
                    exit(0);
                } else {
                    $_SESSION['status'] = "Logout Failed!";
                    header("Location: /login");
                    exit(0);
                }
            } else {
                $_SESSION['status'] = "This Email does not Exist";
                header("Location: /login");
                exit(0);
            }
        } else {
            $_SESSION['status'] = "Not Allowed";
            header("Location: /login");
            exit(0);
        }
    }


    public function resendEmail()
    {
        if (isset($_POST['resend_email_verify_btn'])) {
            if (!empty(trim($_POST['email']))) {

                $email = trim($_POST['email']);

                $checkemail_query = "SELECT * FROM users WHERE email = :email LIMIT 1";
                $stmt = $this->conn->prepare($checkemail_query);
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                $stmt->execute();


                if ($stmt->rowCount() > 0) {
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    if ($row['verify_status'] == "0") {

                        $name = $row['name'];
                        $email = $row['email'];
                        $verify_token = $row['verify_token'];
                        $verifyUser = new PhpMailerUser();
                        $verifyUser->resend_email_verify($name, $email, $verify_token);
                        $_SESSION['status'] = "Verification email has been sent to you email addres";
                        header("Location: /login");
                        exit(0);
                    } else {
                        $_SESSION['status'] = "Email Already Verified. Please Log In";
                        header("Location: /login");
                        exit(0);
                    }
                } else {
                    $_SESSION['status'] = "Email Is not Registred. Please Registred Now";
                    header("Location: /register");
                    exit(0);
                }
            } else {
                $_SESSION['status'] = "Please Enter the Email field";
                header("Location: /resendemail");
                exit(0);
            }
        } else {
            # code...
        }
    }

    public function getUserById($email)
    {   
        $query = "SELECT * FROM users WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $email, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateUser()
    {
        if (isset($_POST['update_profile'])) {
            $name = $_POST['name'];
            $phone = $_POST['phone'];
            $id = $_POST['email'];
            
            $query = "UPDATE users SET name = :name, phone = :phone WHERE email = :email";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':email', $id, PDO::PARAM_STR);
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':phone', $phone, PDO::PARAM_INT);
            $stmt->execute();

            if ($stmt) {
                $_SESSION['status'] = "Login Again";
                header("Location: logout.php");
            } else {
                $_SESSION['status'] = "Update Profile Failed";
                header("Location: /home");
            }
        }
    }


}





$code = new UserControllers();
$code->register();
$code->login();
$code->resendEmail();
$code->updateUser();
$code->logout();
