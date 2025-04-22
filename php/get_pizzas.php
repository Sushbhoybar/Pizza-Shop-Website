<?php
include "db_connect.php";

// Fetch pizzas from database
$result = $conn->query("SELECT * FROM pizzas ORDER BY category");
$pizzas = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $pizzas[$row['category']][] = $row;
    }
}

// Return as JSON
header('Content-Type: application/json');
echo json_encode($pizzas);
?>
