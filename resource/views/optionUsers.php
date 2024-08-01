<?php 
session_start();
include('../template/header.php');
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
                        <h5 class="mb-0">Verify Yourself</h5>
                    </div>
                    <div class="card-body text-center">
                        <p>Please choose a verification method:</p>
                        <a href="../auth/emailVerification.php" class="btn btn-outline-primary btn-lg m-2">Email Verification</a>
                        <a href="../auth/codeAuthenticator.php" class="btn btn-outline-secondary btn-lg m-2">Code Authenticator</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('../template/footer.php'); ?>
