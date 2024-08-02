<?php
include '../config/connection.php';

class PengelolaanBarang
{
    private $conn;

    public function __construct()
    {
        $db = new Connection();
        $this->conn = $db->connectionDatabase();
    }

    public function addedTask()
    {
        if (isset($_POST['added_task_btn'])) {
            $title = $_POST['title'];
            $description = $_POST['description'];
            $due_date = $_POST['due_date'];

            $query = "INSERT INTO tasks (title, description, due_date) VALUES (:title, :description, :due_date)";
            $stmt = $this->conn->prepare($query);
            $result = $stmt->execute([
                'title' => $title,
                'description' => $description,
                'due_date' => $due_date,
            ]);

            if ($result) {
                $_SESSION['status'] = "Added Task Successfully";
                header("Location: ../views/listTask.php");
            } else {
                $_SESSION['status'] = "Added Task Failed";
                header("Location: ../views/addedTask.php");
            }
        }
    }
}
