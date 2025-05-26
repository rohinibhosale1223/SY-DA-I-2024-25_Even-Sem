<?php
// save_cart.php

header('Content-Type: application/json');

// Database credentials
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'laptop_shop';

// Connect to database
$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(['error' => 'Database connection failed']);
    exit;
}

// Read JSON input
$data = json_decode(file_get_contents('php://input'), true);
if (!$data || !isset($data['cart'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid cart data']);
    exit;
}

$cart = $data['cart'];

// Clear previous cart entries (optional for overwrite behavior)
$conn->query("TRUNCATE TABLE cart");

// Prepare insert statement
$stmt = $conn->prepare("INSERT INTO cart (product_name, price) VALUES (?, ?)");

// Insert items
foreach ($cart as $item) {
    $name = $item['name'];
    $price = $item['price'];
    $stmt->bind_param("sd", $name, $price);
    if (!$stmt->execute()) {
        error_log("Insert error: " . $stmt->error);
    }
}

$stmt->close();
$conn->close();

http_response_code(200);
echo json_encode(['message' => 'Cart saved successfully']);
?>
