<?php
include "db_connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $category = $_POST["category"];
    $price = $_POST["price"];
    $toppings = $_POST["toppings"];

    // Ensure no empty fields
    if (empty($name) || empty($category) || empty($price) || empty($toppings) || !isset($_FILES["image"])) {
        echo "Error: All fields are required!";
        exit();
    }

    // Handle Image Upload
    $imageName = basename($_FILES["image"]["name"]);
    $imagePath = "assets/" . $imageName;

    if (move_uploaded_file($_FILES["image"]["tmp_name"], "../" . $imagePath)) {
        // Insert into database
        $stmt = $conn->prepare("INSERT INTO pizzas (name, category, price, toppings, image) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssdss", $name, $category, $price, $toppings, $imagePath);

        if ($stmt->execute()) {
            echo "Pizza added successfully!";
        } else {
            echo "Error inserting pizza: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error uploading image.";
    }
}
$conn->close();
?>
