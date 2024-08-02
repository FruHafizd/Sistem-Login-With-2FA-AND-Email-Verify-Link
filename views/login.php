<?php 
session_start();

if (isset($_SESSION['authenticated'])) {
    $_SESSION['status'] = "You are already Logged in";
    header("Location: /dashboard");
    exit(0);
}
include('template/header.php');
?>

<div class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <?php 
                if (isset($_SESSION['status'])) {
                    echo '<div class="alert alert-success">';
                    echo '<h4>' . $_SESSION['status'] . '</h4>';
                    echo '</div>';
                    unset($_SESSION['status']);
                }
                ?>
                <div class="card shadow">
                    <div class="card-header">
                        <h5>Login Form</h5>
                    </div>
                    <div class="card-body">
                        <form action="controllers/userControllers.php" method="post">
                            <div class="form-group mb-3">
                                <label for="email">Email Address</label>
                                <input type="email" name="email" id="email" class="form-control" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="password">Password</label>
                                <input type="password" name="password" id="password" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary" name="login_now_btn">Login Now</button>
                            </div>
                        </form>
                        <div class="mt-3">
                            <a href="/register">REGISTER HERE</a> |
                            <a href="/resendemail">RESEND EMAIL VERIFICATION</a> |
                            <a href="password-reset.php">FORGOT PASSWORD?</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('template/footer.php'); ?>
