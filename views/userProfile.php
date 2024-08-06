<?php
session_start();
require('template/header.php');
require('controllers/authentication.php');
require('template/sidebars.php');
require_once('controllers/userControllers.php');
require_once 'controllers/codeAuthenticator.php';

// Ambil email dari session
$email = $_SESSION['auth_user']['email'];

// Buat instance UserControllers dan ambil data pengguna
$userControllers = new UserControllers();
$user = $userControllers->getUserById($email);

// Buat instance CodeAuthenticator
$codeAuthen = new CodeAuthenticator();
$codeAuthen->generateQR(); // Pastikan QR code dihasilkan

?>

<main class="col-sm-10 bg-body-tertiary" id="main">
    <div class="container-fluid">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Profile</h1>
        </div>

        <div class="py-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <!-- Display QR Code -->
                        <div class="mb-4 text-center">
                            <div id="qrcode" class="mb-3" align="center"></div>
                            <p>Scan this QR code with your authenticator app</p>
                        </div>

                        <!-- User Profile Form -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">User Profile</h5>
                            </div>
                            <div class="card-body">
                                <form action="../controllers/userControllers.php" method="post">
                                    <input type="hidden" name="id" value="<?= htmlspecialchars($user['email']); ?>">

                                    <div class="mb-3">
                                        <label for="username" class="form-label">Username</label>
                                        <input type="text" id="username" name="username" class="form-control" value="<?= htmlspecialchars($user['username']) ?>" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="phone" class="form-label">Phone Number</label>
                                        <input type="tel" id="phone" name="phone" class="form-control" value="<?= htmlspecialchars($user['phone']) ?>" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email Address</label>
                                        <input type="email" id="email" name="email" class="form-contol" value="<?= htmlspecialchars($user['email']) ?>" required readonly>
                                    </div>

                                    <div class="d-flex justify-content-between">
                                        <button type="submit" name="update_profile" class="btn btn-primary">Update Now</button>
                                        <a href="/resetPassword" class="btn btn-link">Change Password</a>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Generate TOTP Key Form -->
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Two-Factor Authentication</h5>
                            </div>
                            <div class="card-body">
                                <form action="../controllers/codeAuthenticator.php" method="post">
                                    <button type="submit" name="generate_totp_key" class="btn btn-primary">Generate Code Authentication</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>

<?php include('template/footer.php'); ?>
