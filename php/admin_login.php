<?php
session_start();
include "db_connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    // Check if admin exists
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE email = ? AND role = 'admin'");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($admin_id, $hashed_password);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            $_SESSION["admin_id"] = $admin_id;
            $_SESSION["admin_email"] = $email;
            header("Location: ../admin.html");
            exit();
        } else {
            echo "<script>alert('Invalid email or password'); window.location.href='../admin_login.html';</script>";
        }
    } else {
        echo "<script>alert('Admin not found'); window.location.href='../admin_login.html';</script>";
    }

    $stmt->close();
}
$conn->close();
?>
