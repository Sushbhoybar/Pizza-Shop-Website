<?php
$host = "sql300.byethost8.com";  // Your ByetHost8 MySQL Host Name
$user = "b8_38559766";  // Your MySQL Username
$password = "sushil@z23";  // Your MySQL Password
$database = "b8_38559766_pizza_shop_db";  // Your Database Name

$conn = new mysqli($host, $user, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
