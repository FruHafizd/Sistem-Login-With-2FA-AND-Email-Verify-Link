<?php
include('template/header.php');
require_once('controllers/authentication.php');
require_once('template/sidebars.php');
require_once('model/pengelolaanBarang.php');
require_once('model/kategori.php');

$code = new Kategori();
$categories = $code->getCategories();
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
                                            <td><?= $no++; ?></td>
                                            <td><?= $data['nama'] ?></td>
                                            <td><?= $data['namakategori'] ?></td>
                                            <td><?= $data['deskripsi'] ?></td>
                                            <td><?= $data['jumlah_stok'] ?></td>
                                            <td><?= $data['harga'] ?></td>
                                            <td><?= $data['pemasok'] ?></td>
                                            <td>
                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" data-name="<?= htmlspecialchars($data['nama']) ?>" data-category="<?= htmlspecialchars($data['namakategori']) ?>" data-description="<?= htmlspecialchars($data['deskripsi']) ?>" data-stock="<?= htmlspecialchars($data['jumlah_stok']) ?>" data-price="<?= htmlspecialchars($data['harga']) ?>" data-supplier="<?= htmlspecialchars($data['pemasok']) ?>">
                                                    View
                                                </button>
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

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg"> <!-- Use modal-lg class for larger modal -->
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Detail Barang</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="model/pengelolaanBarang.php" method="post">
                        <div class="modal-body">
                            <div class="form-group mb-3">
                                <label for="nama">Nama</label>
                                <input type="text" id="nama" name="nama" class="form-control" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="kategori">Kategori</label>
                                <select id="kategori" name="kategori" class="form-control" required>
                                    <option value="" disabled selected>Pilih Kategori</option>
                                    <?php while ($row = $categories->fetch(PDO::FETCH_ASSOC)) { ?>
                                        <option value="<?= htmlspecialchars($row['kategori']) ?>">
                                            <?= htmlspecialchars($row['namakategori']) ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label for="deskripsi">Deskripsi</label>
                                <textarea id="deskripsi" name="deskripsi" class="form-control" rows="3" required></textarea>
                            </div>
                            <div class="form-group mb-3">
                                <label for="jumlah_stok">Jumlah Stok</label>
                                <input type="number" id="jumlah_stok" name="jumlah_stok" class="form-control" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="harga">Harga</label>
                                <input type="number" id="harga" name="harga" class="form-control" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="pemasok">Pemasok</label>
                                <input type="text" id="pemasok" name="pemasok" class="form-control" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" name="update_item_btn" class="btn btn-primary">Perbarui Barang</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</main>

<?php
include('template/footer.php');
?>