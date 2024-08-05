<?php 
include('controllers/authentication.php');
include('template/header.php');
include('template/sidebars.php');


?>


<main class="col-sm-10 bg-body-tertiary" id="main">
        <div class="container-fluid">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom" id="title">
                <h1 class="h2">Dashboard</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle d-flex align-items-center gap-1">
                        <i class="bi bi-calendar3"></i>
                        This week
                    </button>
                </div>
            </div>

            <form action="controllers/codeAuthenticator.php" method="post">
                <button type="submit" name="generate_totp_key" class="btn btn-primary mt-3">Generate TOTP Secret Key</button>
            </form>






</main>



<?php 
include('template/footer.php');
?>
