<?php
include('controllers/authentication.php');
include('template/header.php');
include('template/sidebars.php');
require_once('model/account.php');


?>


<main class="col-sm-10 bg-body-tertiary" id="main">
    <div class="container-fluid">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom" id="title">
            <h1 class="h2">Akun</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
            </div>
        </div>

        <div class="row">
            <div class="col-12 mb-4 mb-lg-0">
                <div class="card">
                    <div class="d-flex justify-content-between align-items-center card-header">
                        <h5 class="m-0">Akun</h5>
                        <form class="d-flex" method="GET" action="">
                            <input class="form-control me-2" type="search" name="search" placeholder="Cari Produk" aria-label="Search" value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
                            <button class="btn btn-outline-secondary" type="submit">Search</button>
                        </form>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Username</th>
                                        <th scope="col">Nomor Handphone</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    $log = new Account();
                                    $result = $log->displayAccount();
                                    while ($data = $result->fetch(PDO::FETCH_ASSOC)) {
                                    ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= htmlspecialchars($data['email']) ?></td>
                                            <td><?= htmlspecialchars($data['username']) ?></td>
                                            <td><?= htmlspecialchars($data['phone']) ?></td>
                                            <td>
                                                <a href="../../controllers/logoutUser.php?id=<?= $data['id'] ?>" class="btn btn-success" style="color: white;">Logout</a>
                                                <a href="javascript:void(0);" onclick="confirmDelete(<?= $data['id'] ?>)" class="btn btn-danger" style="color: white;">Hapus Akun</a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>






</main>



<?php
include('template/footer.php');
?>