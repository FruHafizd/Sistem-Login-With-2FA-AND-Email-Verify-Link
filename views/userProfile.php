<?php
require('template/header.php');
require('controllers/authentication.php');
require('template/sidebars.php');
// require('controllers/userControllers.php');



$email = $_SESSION['auth_user']['user_id'];
// $userControllers = new UserControllers();
// $user = $userControllers->getUserById($email);

// if (!$user) {
//     $_SESSION['status'] = "User Not Found.";
//     header("Location: /home");
//     exit();
// }
?>



<main class="col-sm-10 bg-body-tertiary" id="main">
    <div class="container-fluid">

        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom" id="title">
            <h1 class="h2">Profile</h1>
        </div>

        <div class="py-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card shadow">
                            <div class="card-header">
                                <h5 class="mb-0">Profile Edit</h5>
                            </div>
                            <div class="card-body">
                                <form action="../controllers/userControllers.php" method="post">
                                    <input type="hidden" name="id" value="<?= htmlspecialchars($user['email']) ?>">
                                    <div class="form-group mb-3">
                                        <label for="name">Name</label>
                                        <input type="text" id="name" name="name" class="form-control" value="<?= htmlspecialchars($user['name']) ?>" required>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="phone">Phone Number</label>
                                        <input type="tel" id="phone" name="phone" class="form-control" value="<?= htmlspecialchars($user['phone']) ?>" required>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="email">Email Address</label>
                                        <input type="email" id="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email']) ?>" required readonly>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" name="update_profile" class="btn btn-primary">Update Now</button>
                                    </div>
                                    <a href="password-reset.php">Here For Change Password</a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

</main>



<?php include('template/footer.php') ?>