<?php
include('template/header.php');
include('controllers/authentication.php');
include('template/topbar.php');
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <h1>Pengelolaan Barang</h1>
            <section class="container justify-content-center mt-5">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-striped" id="example" style="width: 100%;">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Kategori</th>
                                    <th scope="col">Deskripsi</th>
                                    <th scope="col">Jumlah Stok</th>
                                    <th scope="col">Harga</th>
                                    <th scope="col">Pemasok</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                // $tasks = new Tasks();
                                // $result = $tasks->displayTask();
                                while ($data = $result->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                    <tr>
                                        <td><?= $no++;  ?></td>
                                        <td><?= $data['title'] ?></td>
                                        <td><?= $data['description'] ?></td>
                                        <td><?= $data['due_date'] ?></td>
                                        <td><?= $data['status'] ?></td>
                                        <td>
                                            <a href="updateTask.php?id=<?= $data['id'] ?>" class="btn btn-success" style="color: white;">Edit</a>
                                            <a href="javascript:void(0);" onclick="confirmDelete(<?= $data['id'] ?>)" class="btn btn-danger" style="color: white;">Hapus</a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

        </div>
    </div>
</div>

<?php
include('template/footer.php');
?>