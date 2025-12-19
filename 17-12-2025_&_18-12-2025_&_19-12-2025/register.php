<?php
include "db.php";

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $email    = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (username, email, password)
            VALUES (:username, :email, :password)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':username' => $username,
        ':email' => $email,
        ':password' => $password
    ]);

    echo "Registration successful";
    header("Location: login.php");

}
?>

<form method="post">
    Username: <input type="text" name="username" required><br><br>
    Email: <input type="email" name="email" required><br><br>
    Password: <input type="password" name="password" required><br><br>
    <button type="submit" name="register">Register</button>
</form>
