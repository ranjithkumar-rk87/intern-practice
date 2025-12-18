<?php
include "db.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conn->prepare("DELETE FROM users WHERE id = :id");
    $stmt->execute([':id' => $id]);

    echo "User deleted successfully";
}
?>
