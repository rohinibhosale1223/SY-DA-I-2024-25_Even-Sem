<?php
session_start();
require 'cart_db.php';

$user_id = 1;

if (isset($_POST['add'])) {
    $stmt = $mysqli->prepare("INSERT INTO healthcare_cart (user_id, product_id, name, price, qty) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("iisdi", $user_id, $_POST['id'], $_POST['name'], $_POST['price'], $_POST['qty']);
    $stmt->execute();
}

if (isset($_GET['remove'])) {
    $stmt = $mysqli->prepare("DELETE FROM healthcare_cart WHERE user_id=? AND product_id=?");
    $stmt->bind_param("ii", $user_id, $_GET['remove']);
    $stmt->execute();
}

$result = $mysqli->query("SELECT * FROM healthcare_cart WHERE user_id = $user_id");

echo "<h2>Your Healthcare Cart</h2>";
if ($result->num_rows === 0) {
    echo "Your cart is empty.";
} else {
    echo "<ul>";
    while ($item = $result->fetch_assoc()) {
        echo "<li>{$item['name']} - ₹{$item['price']} x {$item['qty']} 
              <a href='healthcare_cart.php?remove={$item['product_id']}'>Remove</a></li>";
    }
    echo "</ul>";
}
?>

