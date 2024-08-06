<?php
include('template/header.php');
include('controllers/authentication.php');
include('template/sidebars.php');
include('model/kategori.php');

$code = new Kategori();
$categories = $code->getCategories();
?>

<main class="col-sm-10 bg-body-tertiary" id="main">
    <div class="container-fluid">
        <!-- Title Section -->
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom" id="title">
            <h1 class="h2">Tambah Barang</h1>
        </div>

        <!-- Form Section -->
        <div class="row justify-content-center py-5">
            <div class="col-12 mb-4 mb-lg-0">
                <form action="model/pengelolaanBarang.php" method="post">
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
                    <div class="form-group">
                        <button type="submit" name="added_item_btn" class="btn btn-primary w-100">Tambah Barang</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
    </div>
</main>

<?php
include('template/footer.php');
?>