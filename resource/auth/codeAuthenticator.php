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
                    echo '<div class="alert alert-success text-center">';
                    echo '<h4>' . $_SESSION['status'] . '</h4>';
                    echo '</div>';
                    unset($_SESSION['status']);
                }
                ?>
                <div class="card shadow">
                    <div class="card-header">
                        <h5 class="mb-0">Code Authenticator</h5>
                    </div>
                    <div class="card-body">
                        <form action="../../app/controllers/userControllers.php" method="post">
                            <div class="form-group mb-3">
                                <label for="auth_code">Authentication Code</label>
                                <input type="text" id="auth_code" name="auth_code" class="form-control" required>
                            </div>
                            <div class="form-group text-center">
                                <button type="submit" name="authenticator_btn" class="btn btn-primary">Authenticate</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('../template/footer.php'); ?>
