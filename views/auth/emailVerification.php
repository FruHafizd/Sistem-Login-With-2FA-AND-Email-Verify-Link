<?php 
session_start();
include('template/header.php');
include('controllers/sessionCheck.php');

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
                        <h5 class="mb-0">Email Verification</h5>
                    </div>
                    <div class="card-body text-center">
                        <p>An email verification link has been sent to your email address. Please check your inbox and follow the instructions to verify your email.</p>
                        <p>If you did not receive the email, please check your spam folder or <a href="/resendemail">click here</a> to resend the verification email.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('template/footer.php'); ?>
