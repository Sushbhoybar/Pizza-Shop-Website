<?php
include "db_connect.php";

header("Content-Type: application/json");

$result = $conn->query("SELECT * FROM orders ORDER BY order_time DESC");
$orders = [];

while ($row = $result->fetch_assoc()) {
    $orders[] = $row;
}

echo json_encode(["orders" => $orders]);
?>
