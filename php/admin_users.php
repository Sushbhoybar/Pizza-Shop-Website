<?php
session_start();
include "db_connect.php";

// Ensure admin access
if (!isset($_SESSION["admin_id"])) {
    echo json_encode(["status" => "error", "message" => "Access denied!"]);
    exit();
}

$data = json_decode(file_get_contents("php://input"), true);

// Delete User
if (isset($data["user_id"]) && isset($data["delete"])) {
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $data["user_id"]);
    $stmt->execute();
    echo json_encode(["status" => "success", "message" => "User deleted!"]);
    exit();
}
?>
