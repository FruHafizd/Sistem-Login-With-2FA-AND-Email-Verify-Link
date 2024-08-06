<?php
require_once __DIR__  . '/../config/connection.php';
include('phpMailer.php');
include('codeAuthenticator.php');
include('loginAttempt.php');
session_start();

class UserControllers
{
    private $conn;

    public function __construct()
    {
        $db = new Connection();
        $this->conn = $db->connectionDatabase();
    }

    public function register()
    {
        if (isset($_POST['register_btn'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];
            $password_hashed = password_hash($password, PASSWORD_BCRYPT);
            $phone = $_POST['phone'];
            $username = $_POST['username'];
            $verify_token = md5(rand());
            $minLength = 8;

            // Prepare and execute statement to check if email already exists
            $check_email_query = "SELECT email FROM users WHERE email = :email LIMIT 1";
            $stmt = $this->conn->prepare($check_email_query);
            $stmt->execute(['email' => $email]);

            if (strlen($password) < $minLength || strlen($confirm_password) < $minLength) {
                $_SESSION['status'] = "Password Too Short, Minimum Password 8 Characters";
                header("Location: /register");
                exit();
            }

            if ($password == $confirm_password) {
                if ($stmt->rowCount() > 0) {
                    $_SESSION['status'] = "Email Id Already Exists";
                    header("Location: /register");
                    exit();
                } else {
                    // Prepare and execute statement to insert new user
                    $query = "INSERT INTO users (username, email, password, phone, verify_token) VALUES (:username, :email, :password, :phone, :verify_token)";
                    $stmt = $this->conn->prepare($query);
                    $result = $stmt->execute([
                        'username' => $username,
                        'email' => $email,
                        'password' => $password_hashed,
                        'phone' => $phone,
                        'verify_token' => $verify_token
                    ]);

                    if ($result) {
                        // Ambil data user yang baru terdaftar
                        $login_query = "SELECT * FROM users WHERE email = :email LIMIT 1";
                        $stmt = $this->conn->prepare($login_query);
                        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                        $stmt->execute();
                        $row = $stmt->fetch(PDO::FETCH_ASSOC);
                        if ($row) {
                            $_SESSION['register'] = [
                                'verify_token' => $row['verify_token'],
                                'username' => $row['username'],
                                'email' => $row['email'],
                            ];

                            $_SESSION['status'] = "Registration Successfully, Please Verify Your Account";
                            header("Location: /emailVerify");
                            exit();
                        } else {
                            $_SESSION['status'] = "Failed to retrieve user data";
                            header("Location: /register");
                            exit();
                        }
                    } else {
                        $_SESSION['status'] = "Registration Failed";
                        header("Location: /register");
                        exit();
                    }
                }
            } else {
                $_SESSION['status'] = "Password Doesn't Match With Confirm Password";
                header("Location: /register");
                exit();
            }
        }
    }

    public function login()
    {
        if (isset($_POST['login_now_btn'])) {
            if (!empty(trim($_POST['email'])) && !empty(trim($_POST['password']))) {
                $email = trim($_POST['email']);
                $password = trim($_POST['password']);
                $ipAddress = $_SERVER['REMOTE_ADDR'];

                // Verifikasi reCAPTCHA
                $recaptcha = $this->reCaptcha();
                if (!$recaptcha) {
                    $_SESSION['status'] = "reCAPTCHA verification failed. Please try again.";
                    header("Location: /login");
                    exit(0);
                }

                $loginAttempt = new LoginAttempt();

                if ($loginAttempt->isBlocked($email, $ipAddress)) {
                    $_SESSION['status'] = "Anda telah diblokir. Coba lagi nanti.";
                    header("Location: /login");
                    exit(0);
                }

                // Cari pengguna berdasarkan email
                $login_query = "SELECT * FROM users WHERE email = :email LIMIT 1";
                $stmt = $this->conn->prepare($login_query);
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                $stmt->execute();

                if ($stmt->rowCount() > 0) {
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    $hashed_password = $row['password'];

                    $_SESSION['auth_user'] = [
                        'user_id' => $row['id'],
                        'verify_token' => $row['verify_token'],
                        'username' => $row['username'],
                        'phone' => $row['phone'],
                        'email' => $row['email'],
                        'secret_key' => $row['secret_key'],
                    ];

                    if (password_verify($password, $hashed_password)) {
                        if ($_SESSION['is_verified'] == TRUE) {
                            $_SESSION['authenticated'] = TRUE;
                            $_SESSION['auth_user'] = [
                                'user_id' => $row['id'],
                                'verify_token' => $row['verify_token'],
                                'username' => $row['username'],
                                'phone' => $row['phone'],
                                'email' => $row['email'],
                            ];
                            $_SESSION['status'] = "You Are Logged In Successfully";
                            $loginAttempt->clearAttempts($email, $ipAddress);
                            header("Location: /home");
                            exit(0);
                        } else {
                            $_SESSION['status'] = "Please Verify Your Account To Log In";
                            header("Location: /verifyuser");
                            exit(0);
                        }
                    } else {
                        $loginAttempt->addAttempt($email, $ipAddress);
                        $_SESSION['status'] = "Invalid Email Or Password";
                        header("Location: /login");
                        exit(0);
                    }
                } else {
                    $loginAttempt->addAttempt($email, $ipAddress);
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

    public function resendEmail()
    {
        if (isset($_POST['resend_email_verify_btn'])) {
            if (!empty(trim($_POST['email']))) {

                $email = trim($_POST['email']);

                // Verifikasi reCAPTCHA
                $recaptcha = $this->reCaptcha();
                if (!$recaptcha) {
                    $_SESSION['status'] = "reCAPTCHA verification failed. Please try again.";
                    header("Location: /resendemail");
                    exit(0);
                }

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
        $query = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public function updateUser()
    {
        if (isset($_POST['update_profile'])) {
            $username = $_POST['username'];
            $phone = $_POST['phone'];
            $id = $_POST['email'];

            $query = "UPDATE users SET username = :username, phone = :phone WHERE email = :email";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':email', $id, PDO::PARAM_STR);
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
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

    public function authentifactionApllication()
    {
        if (isset($_POST['authenticator_btn'])) {
            $totpCodeInput = trim($_POST['totpCode']);

            if (isset($_SESSION['auth_user']['username']) && isset($_SESSION['auth_user']['email'])) {
                $codeAuthentication = new CodeAuthenticator;
                $expectedTotpCode = $codeAuthentication->getTotpCodeUser();
                if ($totpCodeInput === $expectedTotpCode) {
                    $_SESSION['is_verified'] = true;
                    $_SESSION['authenticated'] = true;
                    $_SESSION['status'] = "You Are Logged In Successfully";
                    header("Location: /home");
                    exit(0);
                } else {
                    $_SESSION['status'] = "Invalid Authentication Code";
                    header("Location: /authenticationApplication");
                    exit(0);
                }
            } else {
                $_SESSION['status'] = "User not found";
                header("Location: /verifyuser");
                exit(0);
            }
        }
    }

    public function passwordResetLink()
    {
        if (isset($_POST['password_reset_link'])) {
            $email = trim($_POST['email']);
            $token = md5(rand());

            $check_email = "SELECT email FROM users WHERE email = :email LIMIT 1";
            $stmt = $this->conn->prepare($check_email);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();

            // Verifikasi reCAPTCHA
            $recaptcha = $this->reCaptcha();
            if (!$recaptcha) {
                $_SESSION['status'] = "reCAPTCHA verification failed. Please try again.";
                header("Location: /resetPassword");
                exit(0);
            }

            if ($stmt->rowCount() > 0) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $get_name = $row['name'];
                $get_email = $row['email'];

                $update_token = "UPDATE users SET verify_token = :token WHERE email = :email LIMIT 1";
                $update_stmt = $this->conn->prepare($update_token);
                $update_stmt->bindParam(':token', $token, PDO::PARAM_STR);
                $update_stmt->bindParam(':email', $get_email, PDO::PARAM_STR);
                $update_result = $update_stmt->execute();

                if ($update_result) {
                    $_SESSION['auth_user'] = [
                        'verify_token' => $token, // Simpan token yang baru di-generate
                        'email' => $get_email,
                    ];

                    $verifyUser = new PhpMailerUser();
                    $verifyUser->send_password_reset($get_name, $get_email, $token);
                    $_SESSION['status'] = "We emailed you a password reset link";
                    header("Location: /resetPassword");
                    exit(0);
                } else {
                    $_SESSION['status'] = "Something went wrong. #1";
                    header("Location: /resetPassword");
                    exit(0);
                }
            } else {
                $_SESSION['status'] = "No Email Found";
                header("Location: /resetPassword");
                exit(0);
            }
        }
    }

    public function passwordUpdate()
    {
        if (isset($_POST['password_update'])) {
            $email = trim($_POST['email']);
            $new_password = trim($_POST['new_password']);
            $confirm_password = trim($_POST['confirm_password']);
            $password_hashed = password_hash($confirm_password, PASSWORD_BCRYPT);
            $token = trim($_POST['password_token']);
            $minLength = 8;

            if (!empty($token)) {
                if (!empty($email) && !empty($new_password) && !empty($confirm_password)) {
                    // CHECK TOKEN VALID OR NOT
                    $check_token = "SELECT verify_token FROM users WHERE verify_token = :token LIMIT 1";
                    $stmt = $this->conn->prepare($check_token);
                    $stmt->bindParam(':token', $token, PDO::PARAM_STR);
                    $stmt->execute();

                    if ($stmt->rowCount() > 0) {
                        if (strlen($new_password) < $minLength || strlen($confirm_password) < $minLength) {
                            $_SESSION['status'] = "Password Too Short, Minimum Password 8 Characters";
                            header("Location: /changePassword?token=$token&email=$email");
                            exit();
                        }
                        if ($new_password == $confirm_password) {
                            $update_password = "UPDATE users SET password = :password WHERE verify_token = :token LIMIT 1";
                            $update_stmt = $this->conn->prepare($update_password);
                            $update_stmt->bindParam(':password', $password_hashed, PDO::PARAM_STR);
                            $update_stmt->bindParam(':token', $token, PDO::PARAM_STR);
                            $update_result = $update_stmt->execute();

                            if ($update_result) {
                                $new_token = md5(rand());
                                $update_to_new_token = "UPDATE users SET verify_token = :new_token WHERE verify_token = :old_token";
                                $new_token_stmt = $this->conn->prepare($update_to_new_token);
                                $new_token_stmt->bindParam(':new_token', $new_token, PDO::PARAM_STR);
                                $new_token_stmt->bindParam(':old_token', $token, PDO::PARAM_STR);
                                $new_token_stmt->execute();

                                $_SESSION['status'] = "New Password Succesfully Updated!";
                                header("Location: /login");
                                exit(0);
                            } else {
                                $_SESSION['status'] = "Did not update password something went wrong";
                                header("Location: /changePassword?token=$token&email=$email");
                                exit(0);
                            }
                        } else {
                            $_SESSION['status'] = "Password And confirm password does not match";
                            header("Location: /changePassword?token=$token&email=$email");
                            exit(0);
                        }
                    } else {
                        $_SESSION['status'] = "Invalid Token";
                        header("Location: /changePassword?token=$token&email=$email");
                        exit(0);
                    }
                } else {
                    $_SESSION['status'] = "All filed are mendetory";
                    header("Location: /changePassword?token=$token&email=$email");
                    exit(0);
                }
            } else {
                $_SESSION['status'] = "No Token Available";
                header("Location: /resetPassword");
                exit(0);
            }
        }
    }

    public function reCaptcha()
    {
        // Inisialisasi cURL
        $ch = curl_init('https://www.google.com/recaptcha/api/siteverify');

        // Set opsi cURL
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, [
            'secret' => '6Ld9sR8qAAAAACRqnBcuGlsYpgoVaV-mYXNgU6TY',
            'response' => $_POST['g-recaptcha-response'],
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Eksekusi cURL
        $response = curl_exec($ch);

        // Periksa kesalahan cURL
        if (curl_errno($ch)) {
            // Tangani kesalahan cURL jika ada
            curl_close($ch);
            return false;
        }

        // Tutup sesi cURL
        curl_close($ch);

        // Decode respons JSON
        $result = json_decode($response);

        // Periksa apakah decode JSON berhasil
        if (json_last_error() !== JSON_ERROR_NONE) {
            return false;
        }

        // Periksa apakah reCAPTCHA valid
        return isset($result->success) && $result->success;
    }
}





$code = new UserControllers();
$code->register();
$code->login();
$code->updateUser();
$code->resendEmail();
$code->authentifactionApllication();
$code->passwordResetLink();
$code->passwordUpdate();
