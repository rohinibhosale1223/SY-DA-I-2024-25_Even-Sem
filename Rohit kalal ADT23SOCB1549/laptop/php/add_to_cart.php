<?php
// php/add_to_cart.php

$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'laptop_shop';

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die(json_encode(['error' => 'DB Connection failed']));
}

$data = json_decode(file_get_contents('php://input'), true);

if (!$data || !isset($data['name']) || !isset($data['price'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid data']);
    exit;
}

$name = $data['name'];
$price = $data['price'];

$stmt = $conn->prepare("INSERT INTO cart (product_name, price) VALUES (?, ?)");
$stmt->bind_param("sd", $name, $price);
$stmt->execute();
$stmt->close();
$conn->close();

echo json_encode(['message' => 'Product added to cart in DB']);
?>
