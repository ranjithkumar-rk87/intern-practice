<?php
include "db.php";

$id = $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM users WHERE id = :id");
$stmt->execute([':id' => $id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (isset($_POST['update'])) {
    $name  = $_POST['name'];
    $email = $_POST['email'];

    $sql = "UPDATE users 
            SET username = :name, email = :email
            WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':name' => $name,
        ':email' => $email,
        ':id' => $id
    ]);

    echo "User updated successfully";
}
?>

<form method="post">
    Name: <input type="text" name="name" value="<?= $user['username'] ?>"><br><br>
    Email: <input type="email" name="email" value="<?= $user['email'] ?>"><br><br>
    <button type="submit" name="update">Update</button>
</form>
