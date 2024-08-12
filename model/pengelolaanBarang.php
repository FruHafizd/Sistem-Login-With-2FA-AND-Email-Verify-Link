<?php
include __DIR__ . '/../config/connection.php';

class PengelolaanBarang
{
    private $conn;

    public function __construct()
    {
        $db = new Connection();
        $this->conn = $db->connectionDatabase();
    }

    public function addedItem()
    {
        if (isset($_POST['added_item_btn'])) {
            $nama = $_POST['nama'];
            $kategori = $_POST['kategori'];
            $deskripsi = $_POST['deskripsi'];
            $jumlah_stok = $_POST['jumlah_stok'];
            $harga = $_POST['harga'];
            $pemasok = $_POST['pemasok'];


            $query = "INSERT INTO pengelolaan_Barang (nama,kategori,deskripsi,jumlah_stok,harga,pemasok) VALUES (:nama, :kategori, :deskripsi, :jumlah_stok, :harga, :pemasok)";
            $stmt = $this->conn->prepare($query);
            $result = $stmt->execute([
                'nama' => $nama,
                'kategori' => $kategori,
                'deskripsi' => $deskripsi,
                'jumlah_stok' => $jumlah_stok,
                'harga' => $harga,
                'pemasok' => $pemasok,
            ]);

            if ($result) {
                $_SESSION['status'] = "Added Task Successfully";
                header("Location: /barang");
            } else {
                $_SESSION['status'] = "Added Task Failed";
                header("Location: /barang");
            }
        }
    }

    public function updateItem()
    {
        if (isset($_POST['update_item_btn'])) {
            $id = intval($_POST['id']);
            $nama = $_POST['nama'];
            $kategori = $_POST['kategori'];
            $deskripsi = $_POST['deskripsi'];
            $jumlah_stok = intval($_POST['jumlah_stok']);
            $harga = floatval($_POST['harga']);
            $pemasok = $_POST['pemasok'];

            // Debugging
            error_log("ID: $id, Nama: $nama, Kategori: $kategori, Deskripsi: $deskripsi, Jumlah Stok: $jumlah_stok, Harga: $harga, Pemasok: $pemasok");

            $query = "UPDATE pengelolaan_Barang SET nama = :nama, kategori = :kategori, deskripsi = :deskripsi, jumlah_stok = :jumlah_stok, harga = :harga, pemasok = :pemasok WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':nama', $nama, PDO::PARAM_STR);
            $stmt->bindParam(':kategori', $kategori, PDO::PARAM_STR);
            $stmt->bindParam(':deskripsi', $deskripsi, PDO::PARAM_STR);
            $stmt->bindParam(':jumlah_stok', $jumlah_stok, PDO::PARAM_INT);
            $stmt->bindParam(':harga', $harga, PDO::PARAM_STR);
            $stmt->bindParam(':pemasok', $pemasok, PDO::PARAM_STR);
            $result = $stmt->execute();

            if ($result) {
                $_SESSION['status'] = "Updated Item Successfully";
                header("Location: /barang");
            } else {
                $_SESSION['status'] = "Update Item Failed";
                header("Location: /barang");
            }
        }
    }

    public function displayItem()
    {
        $query = "SELECT pb.*, k.namakategori 
        FROM pengelolaan_Barang pb
        JOIN kategori k ON pb.kategori = k.kategori";

        $sth = $this->conn->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $sth->execute();
        return $sth;
    }

    public function getItemById($id) {
        $query = "SELECT * FROM pengelolaan_Barang WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
}

$code = new PengelolaanBarang();
$code->addedItem();
$code->updateItem();
