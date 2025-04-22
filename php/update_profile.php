<?php
session_start();
include "db_connect.php";

if (!isset($_SESSION['user_id'])) {
    die("Not logged in");
}

$user_id = $_SESSION['user_id'];
$phone = $_POST['phone'];
$address = $_POST['address'];

$upload_dir = "../assets/profile_photos/";
$profile_photo = null;

if (!empty($_FILES['profile_photo']['name'])) {
    $file_name = basename($_FILES["profile_photo"]["name"]);
    $target_file = $upload_dir . time() . "_" . $file_name;

    if (move_uploaded_file($_FILES["profile_photo"]["tmp_name"], $target_file)) {
        $profile_photo = str_replace("../", "", $target_file);
    }
}

$query = "UPDATE users SET phone=?, address=?, profile_photo=? WHERE id=?";
$stmt = $conn->prepare($query);
$stmt->bind_param("sssi", $phone, $address, $profile_photo, $user_id);
$stmt->execute();

echo "Profile updated successfully!";
?>
