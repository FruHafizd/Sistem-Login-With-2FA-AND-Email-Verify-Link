<?php
include('template/header.php');
include('controllers/authentication.php');
include('template/sidebars.php');
include('model/pengelolaanBarang.php');
?>

<main class="col-sm-10 bg-body-tertiary" id="main">
    <div class="container-fluid">
        <!-- Title Section -->
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom" id="title">
            <h1 class="h2">Pengelolaan Barang</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
                <div class="btn-group me-2">
                    <a type="button" href="/tambahBarang" class="btn btn-sm btn-outline-secondary">Tambah Barang</a>
                </div>
            </div>
        </div>

        <!-- Product Table Section -->
        <div class="row">
            <div class="col-12 mb-4 mb-lg-0">
                <div class="card">
                    <div class="d-flex justify-content-between align-items-center card-header">
                        <h5 class="m-0">Produk</h5>
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
                                        <th scope="col">Nama Produk</th>
                                        <th scope="col">Kategori</th>
                                        <th scope="col">Deskripsi</th>
                                        <th scope="col">Jumlah Stok</th>
                                        <th scope="col">Harga</th>
                                        <th scope="col">Pemasok</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;         
                                    $tasks = new PengelolaanBarang();
                                    $result = $tasks->displayItem();
                                    while ($data = $result->fetch(PDO::FETCH_ASSOC)) {
                                    ?>
                                        <tr>
                                            <td><?= $no++;  ?></td>
                                            <th scope="row"><?= $data['nama'] ?></th>
                                            <td><?= $data['namakategori'] ?></td>
                                            <td><?= $data['deskripsi'] ?></td>
                                            <td><?= $data['jumlah_stok'] ?></td>
                                            <td><?= $data['harga'] ?></td>
                                            <td><?= $data['pemasok'] ?></td>
                                            <td><a href="#" class="btn btn-sm btn-primary">View</a></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php
include('template/footer.php');
?>
