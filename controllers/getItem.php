<?php
require_once __DIR__  . '/../model/pengelolaanBarang.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $pengelolaanBarang = new PengelolaanBarang();
    $task = $pengelolaanBarang->getItemById($id);
    echo json_encode($task);
}
?>
