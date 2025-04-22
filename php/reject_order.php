<?php
include "db_connect.php";

$data = json_decode(file_get_contents("php://input"), true);
$order_id = $data["order_id"];
$user_email = $data["user_email"];

// Update order status to "Cancelled" instead of deleting
$stmt = $conn->prepare("UPDATE orders SET status = 'Cancelled' WHERE id = ?");
$stmt->bind_param("i", $order_id);

if ($stmt->execute()) {
    echo json_encode(["message" => "Order rejected & marked as 'Cancelled'."]);

    // Auto-delete the canceled order after 1 minute
    sleep(60);
    $stmt = $conn->prepare("DELETE FROM orders WHERE id = ?");
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
} else {
    echo json_encode(["message" => "Error rejecting order."]);
}
?>
