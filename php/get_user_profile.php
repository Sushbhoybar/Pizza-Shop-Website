<?php
session_start();
include "db_connect.php";

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["error" => "Not logged in"]);
    exit;
}

$user_id = $_SESSION['user_id'];
$query = "SELECT full_name, email, phone, address, profile_photo, role FROM users WHERE id=?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Set default profile photo if none is available
if (empty($user['profile_photo'])) {
    $user['profile_photo'] = "default.png"; // Default profile image
}

// Return JSON response
header('Content-Type: application/json');
echo json_encode($user);
?>