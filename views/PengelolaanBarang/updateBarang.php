<?php 
include('template/header.php');
include('controllers/authentication.php');
include('template/topbar.php');
?>

<div class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header">
                        <h5 class="mb-0">Tambah Barang</h5>
                    </div>
                    <div class="card-body">
                        <form action="../model/pengelolaanBarang.php" method="post">
                            <div class="form-group mb-3">
                                <label for="nama">Nama</label>
                                <input type="text" id="nama" name="nama" class="form-control" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="kategori">Kategori</label>
                                <input type="text" id="kategori" name="kategori" class="form-control" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="deskripsi">Deskripsi</label>
                                <input type="text" id="deskripsi" name="deskripsi" class="form-control" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="jumlah_stok">Jumlah Stok</label>
                                <input type="text" id="jumlah_stok" name="jumlah_stok" class="form-control" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="harga">Harga</label>
                                <input type="text" id="harga" name="harga" class="form-control" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="pemasok">Pemasok</label>
                                <input type="text" id="pemasok" name="pemasok" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <button type="submit" name="update_item_btn" class="btn btn-primary">Add Task</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php 
include('template/footer.php')
?>