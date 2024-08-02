<?php
include 'config/connection.php';

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

    public function displayItem()
    {
        $query = "SELECT pb.*, k.namakategori 
        FROM pengelolaan_Barang pb
        JOIN kategori k ON pb.kategori = k.kategori";

        $sth = $this->conn->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $sth->execute();
        return $sth;
    }

}

$code = new PengelolaanBarang();
$code->addedItem();