<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    die("Please log in first.");
}

$cart_id = $_POST['cart_id'];

$sql = "DELETE FROM cart WHERE id = ? AND user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $cart_id, $_SESSION['user_id']);
$stmt->execute();

header("Location: view_cart.php");
?>







<?php
session_start();
include 'cart_db.php';

$user_id = 1; 

if (isset($_POST['add'])) {
    $stmt = $mysqli->prepare("INSERT INTO cart (user_id, product_id, name, price, qty) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("iisdi", $user_id, $_POST['id'], $_POST['name'], $_POST['price'], $_POST['qty']);
    $stmt->execute();
}


if (isset($_GET['remove'])) {
    $stmt = $mysqli->prepare("DELETE FROM cart WHERE user_id=? AND product_id=?");
    $stmt->bind_param("ii", $user_id, $_GET['remove']);
    $stmt->execute();
}

$result = $mysqli->query("SELECT * FROM cart WHERE user_id = $user_id");

echo "<h2>Your Cart</h2>";
if ($result->num_rows === 0) {
    echo "Cart is empty.";
} else {
    echo "<ul>";
    while ($item = $result->fetch_assoc()) {
        echo "<li>{$item['name']} - ₹{$item['price']} x {$item['qty']} 
              <a href='cart_mysql.php?remove={$item['product_id']}'>Remove</a></li>";
    }
    echo "</ul>";
}
?>
<h3>Add Item</h3>
<form method="POST">
    ID: <input type="number" name="id"><br>
    Name: <input type="text" name="name"><br>
    Price: <input type="number" step="0.01" name="price"><br>
    Quantity: <input type="number" name="qty"><br>
    <input type="submit" name="add" value="Add to Cart">
</form>
