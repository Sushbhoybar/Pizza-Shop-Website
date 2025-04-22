<?php
session_start();
include "db_connect.php";

// Ensure only customers can order
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "customer") {
    echo json_encode(["status" => "error", "message" => "Access denied! Customers only."]);
    exit();
}

$user_id = $_SESSION["user_id"];
$data = json_decode(file_get_contents("php://input"), true);
$cart = $data["cart"];

// Insert each item into orders
foreach ($cart as $item) {
    $pizza_id = $item["id"];
    $quantity = $item["quantity"];
    $total_price = $item["price"] * $quantity;

    $stmt = $conn->prepare("INSERT INTO orders (user_id, pizza_id, quantity, total_price) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiid", $user_id, $pizza_id, $quantity, $total_price);
    $stmt->execute();
    $stmt->close();
}

echo json_encode(["status" => "success", "message" => "Order placed successfully!"]);
$conn->close();
?>
