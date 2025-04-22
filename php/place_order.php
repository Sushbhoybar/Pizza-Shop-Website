<?php
include "db_connect.php";
session_start();

header("Content-Type: application/json");

if (!isset($_SESSION["user_id"]) || !isset($_SESSION["email"])) {
    echo json_encode(["status" => "error", "message" => "User not logged in"]);
    exit();
}

$data = json_decode(file_get_contents("php://input"), true);

if (!$data || empty($data["cart"]) || empty($data["address"]) || empty($data["paymentMethod"])) {
    echo json_encode(["status" => "error", "message" => "Invalid request data"]);
    exit();
}

$user_id = $_SESSION["user_id"];
$user_email = $_SESSION["email"];
$address = trim($data["address"]);
$paymentMethod = trim($data["paymentMethod"]);
$cart = $data["cart"];

$validPaymentMethods = ["Credit/Debit Card", "PayPal", "Cash on Delivery"];
if (!in_array($paymentMethod, $validPaymentMethods)) {
    echo json_encode(["status" => "error", "message" => "Invalid payment method"]);
    exit();
}

$success = true;
$errorMessage = "";

foreach ($cart as $item) {
    $stmt = $conn->prepare("INSERT INTO orders (user_id, user_email, pizza_id, pizza_name, quantity, total_price, address, payment_method, status) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'Pending')");
    
    if (!$stmt) {
        $errorMessage = "Prepare failed: " . $conn->error;
        $success = false;
        break;
    }

    $totalPrice = $item["price"] * $item["quantity"];
    $stmt->bind_param("isissdss", $user_id, $user_email, $item["id"], $item["name"], $item["quantity"], $totalPrice, $address, $paymentMethod);
    
    if (!$stmt->execute()) {
        $errorMessage = "Execute failed: " . $stmt->error;
        $success = false;
        break;
    }

    $stmt->close();
}

if ($success) {
    echo json_encode(["status" => "success", "message" => "Order placed successfully!"]);
} else {
    echo json_encode(["status" => "error", "message" => "Something went wrong. Debug: " . $errorMessage]);
}
?>
