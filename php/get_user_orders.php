<?php
include "db_connect.php";
session_start();

header("Content-Type: application/json");

if (!isset($_SESSION["user_id"])) {
    echo json_encode(["orders" => []]);
    exit();
}

$user_id = $_SESSION["user_id"];
$result = $conn->query("SELECT * FROM orders WHERE user_id = $user_id ORDER BY order_time DESC");
$orders = [];

while ($row = $result->fetch_assoc()) {
    $orders[] = $row;
}

echo json_encode(["orders" => $orders]);
?>
