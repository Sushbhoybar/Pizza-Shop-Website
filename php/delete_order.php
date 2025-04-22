<?php
include "db_connect.php";

$data = json_decode(file_get_contents("php://input"), true);
$order_id = $data["order_id"];

$stmt = $conn->prepare("DELETE FROM orders WHERE id = ?");
$stmt->bind_param("i", $order_id);

if ($stmt->execute()) {
    echo json_encode(["message" => "Order deleted successfully!"]);
} else {
    echo json_encode(["message" => "Error deleting order."]);
}
?>
