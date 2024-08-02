<?php 
include('template/header.php');
include('controllers/authentication.php');
include('template/topbar.php');
// session_destroy();

?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <?php 
                if (isset($_SESSION['status'])) {
                    echo '<div class="alert alert-success">';
                    echo '<h4>' . $_SESSION['status'] . '</h4>';
                    echo '</div>';
                    unset($_SESSION['status']);
                }
                ?>
            <h1>Hello, world!</h1>
            <form action="controllers/codeAuthenticator.php" method="post">
                <button type="submit" name="generate_totp_key" class="btn btn-primary mt-3">Generate TOTP Secret Key</button>
            </form>
        </div>
    </div>
</div>

<?php 
include('template/footer.php');
?>
