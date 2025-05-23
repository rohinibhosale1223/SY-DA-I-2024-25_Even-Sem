<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    die("Please log in to view your cart.");
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT cart.id, products.name, products.price, products.image, cart.quantity
        FROM cart
        JOIN products ON cart.product_id = products.id
        WHERE cart.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$total = 0;

echo "<h2>Your Cart</h2>";

while ($row = $result->fetch_assoc()) {
    $subtotal = $row['price'] * $row['quantity'];
    $total += $subtotal;

    echo "<div>
        <img src='{$row['image']}' width='100'>
        <p>{$row['name']}</p>
        <p>Price: ₹{$row['price']}</p>
        <p>Quantity: {$row['quantity']}</p>
        <p>Subtotal: ₹$subtotal</p>
        <form method='post' action='remove_from_cart.php'>
            <input type='hidden' name='cart_id' value='{$row['id']}'>
            <button type='submit'>Remove</button>
        </form>
    </div><hr>";
}

echo "<h3>Total: ₹$total</h3>";
?>
