<?php
session_start();
include 'config.php';

$user_id = 1;  // dummy user id

// Get cart items
$sql = "SELECT * FROM cart WHERE user_id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$cart_items = $stmt->get_result();

if ($cart_items->num_rows == 0) {
    echo "Your cart is empty. Add items before checkout.";
    exit();
}

// Insert order
$order_date = date('Y-m-d H:i:s');
$insert_order_sql = "INSERT INTO orders (user_id, order_date) VALUES (?, ?)";
$stmt = $conn->prepare($insert_order_sql);
$stmt->bind_param("is", $user_id, $order_date);

if ($stmt->execute()) {
    $order_id = $stmt->insert_id;

    // Insert order items
    $insert_item_sql = "INSERT INTO order_items (order_id, item_name, quantity, price) VALUES (?, ?, ?, ?)";
    $stmt_item = $conn->prepare($insert_item_sql);

    while ($row = $cart_items->fetch_assoc()) {
        $stmt_item->bind_param("isid", $order_id, $row['item_name'], $row['quantity'], $row['price']);
        $stmt_item->execute();
    }

    // Clear cart
    $delete_cart_sql = "DELETE FROM cart WHERE user_id=?";
    $stmt = $conn->prepare($delete_cart_sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();

    echo "Checkout successful! Your order ID is: " . $order_id;
} else {
    echo "Checkout failed. Please try again.";
}
?>
