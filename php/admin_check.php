<?php
session_start();
include "db_connect.php";

if (!isset($_SESSION["admin_id"])) {
    echo "<script>alert('Access denied! Admins only.'); window.location.href='../index.html';</script>";
    exit();
}
?>
