<?php
include "db_connect.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT id, full_name, email, password, role FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user["password"])) {
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["full_name"] = $user["full_name"];
            $_SESSION["email"] = $user["email"];
            $_SESSION["role"] = $user["role"]; // Ensure role is stored

            if ($_SESSION["role"] === "admin") {
                echo json_encode(["status" => "success", "redirect" => "admin_index.html"]);
            } else {
                echo json_encode(["status" => "success", "redirect" => "index.html"]);
            }
        } else {
            echo json_encode(["status" => "error", "message" => "Invalid email or password."]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid email or password."]);
    }
}
?>
