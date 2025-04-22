<?php
session_start();
include "db_connect.php";

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "customer") {
    echo json_encode(["status" => "error", "message" => "Access denied! Customers only."]);
    exit();
}
?>
