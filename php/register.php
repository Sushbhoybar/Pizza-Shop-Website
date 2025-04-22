

<?php
include "db_connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $_POST["full_name"];
    $email = $_POST["email"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $role = $_POST["role"];

    // Check if email already exists
    $checkStmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $checkStmt->bind_param("s", $email);
    $checkStmt->execute();
    $checkStmt->store_result();

    if ($checkStmt->num_rows > 0) {
        echo "Error: Email already registered!";
        exit();
    }
    $checkStmt->close();

    // Insert user into database
    $stmt = $conn->prepare("INSERT INTO users (full_name, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $full_name, $email, $password, $role);

    if ($stmt->execute()) {
        echo "User registered successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
    $stmt->close();


//    if ($stmt->execute()) {
//             echo "<script>alert('Registration successful! You can now log in.'); window.location.href='../login.html';</script>";
//     } else {
//             echo "<script>alert('Error registering user. Please try again!'); window.location.href='../register.html';</script>";
//     }
//     $stmt->close();

}
?>