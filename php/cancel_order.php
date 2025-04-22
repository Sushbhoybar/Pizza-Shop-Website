<?php
include "db_connect.php";

$data = json_decode(file_get_contents("php://input"), true);
$order_id = $data["order_id"];

// Update status to "Cancelled"
$stmt = $conn->prepare("UPDATE orders SET status = 'Cancelled' WHERE id = ?");
$stmt->bind_param("i", $order_id);

if ($stmt->execute()) {
    echo json_encode(["message" => "Order cancelled successfully."]);

    // Auto-delete the order after 1 minute
    sleep(60); // Wait for 1 minute
    $stmt = $conn->prepare("DELETE FROM orders WHERE id = ?");
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
} else {
    echo json_encode(["message" => "Error cancelling order."]);
}
?>
