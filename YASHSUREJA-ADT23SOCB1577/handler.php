<?php
// php/checkout.php
include 'db_connect.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["error" => "User not logged in."]);
    exit();
}

$user_id = $_SESSION['user_id'];

// Validate user input (e.g., address, payment method)
$address = trim($_POST['address'] ?? '');
$payment_method = trim($_POST['payment_method'] ?? '');

if (empty($address) || empty($payment_method)) {
    echo json_encode(["error" => "All fields are required."]);
    exit();
}

// Start transaction
$conn->begin_transaction();

try {
    // Create new order
    $stmt = $conn->prepare("INSERT INTO orders (user_id, address, payment_method, created_at) VALUES (?, ?, ?, NOW())");
    $stmt->bind_param("iss", $user_id, $address, $payment_method);
    $stmt->execute();
    $order_id = $stmt->insert_id;

    // Get cart items
    $stmt = $conn->prepare("SELECT product_id, quantity FROM cart WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $stmt_item = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity) VALUES (?, ?, ?)");
        $stmt_item->bind_param("iii", $order_id, $row['product_id'], $row['quantity']);
        $stmt_item->execute();
    }

    // Clear cart
    $stmt = $conn->prepare("DELETE FROM cart WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();

    $conn->commit();
    echo json_encode(["success" => "Order placed successfully!"]);
} catch (Exception $e) {
    $conn->rollback();
    echo json_encode(["error" => "Checkout failed. Please try again."]);
}
?>
