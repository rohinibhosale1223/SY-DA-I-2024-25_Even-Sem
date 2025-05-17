<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    die("Please log in to add health items to your cart.");
}

$user_id = $_SESSION['user_id'];
$product_id = $_POST['product_id'];
$quantity = $_POST['quantity'];

$sql = "SELECT * FROM healthcare_cart WHERE user_id = ? AND product_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $user_id, $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $new_quantity = $row['quantity'] + $quantity;

    $update = $conn->prepare("UPDATE healthcare_cart SET quantity = ? WHERE user_id = ? AND product_id = ?");
    $update->bind_param("iii", $new_quantity, $user_id, $product_id);
    $update->execute();
} else {
    $insert = $conn->prepare("INSERT INTO healthcare_cart (user_id, product_id, quantity) VALUES (?, ?, ?)");
    $insert->bind_param("iii", $user_id, $product_id, $quantity);
    $insert->execute();
}

echo "Health item added to cart.";
?>
