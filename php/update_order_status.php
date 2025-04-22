<?php
include "db_connect.php";

$data = json_decode(file_get_contents("php://input"), true);
$order_id = $data["order_id"];
$status = $data["status"];

// Prevent updating a cancelled order
$check_stmt = $conn->prepare("SELECT status FROM orders WHERE id = ?");
$check_stmt->bind_param("i", $order_id);
$check_stmt->execute();
$result = $check_stmt->get_result();
$order = $result->fetch_assoc();

if ($order['status'] === 'Cancelled') {
    echo json_encode(["message" => "Cannot update a cancelled order."]);
    exit;
}

// Update the order status
$stmt = $conn->prepare("UPDATE orders SET status = ? WHERE id = ?");
$stmt->bind_param("si", $status, $order_id);

if ($stmt->execute()) {
    echo json_encode(["message" => "Order updated to '$status'."]);
} else {
    echo json_encode(["message" => "Error updating order status."]);
}
?>
