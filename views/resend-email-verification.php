<?php
if (isset($_SESSION['authenticated'])) {
    $_SESSION['status'] = "You are already Logged in";
    header("Location: /home");
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
                <div class="card">
                    <div class="card-header">
                        <h5>Resend Email Verification</h5>
                    </div>
                    <div class="card-body">
                        <form action="../controllers/userControllers.php" method="post">
                            <div class="form-group mb-3">
                                <label for="">Email Address</label>
                                <input type="email" name="email" class="form-control" placeholder="Enter Your Email Address" required>
                            </div>
                            <div class="form-group mb-3">
                                <!-- reCAPTCHA -->
                                <div class="g-recaptcha" data-sitekey="6Ld9sR8qAAAAABS2bTSfofuFn4ancyAqgjFdprut"></div>
                            </div>
                            <div class="form-group mb-3">
                                <button type="submit" name="resend_email_verify_btn" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('template/footer.php'); ?>