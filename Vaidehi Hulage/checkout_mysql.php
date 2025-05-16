<?php
session_start();
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the cart is set and not empty
    if (empty($_SESSION['cart'])) {
        echo "Your cart is empty.";
        exit;
    }

    // Capture and sanitize user inputs
    $name = htmlspecialchars(trim($_POST['name'] ?? ''), ENT_QUOTES, 'UTF-8');
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
    $address = htmlspecialchars(trim($_POST['address'] ?? ''), ENT_QUOTES, 'UTF-8');
    $user_id = $_SESSION['user_id'] ?? 0;

    // Validate inputs
    if (empty($name) || empty($email) || empty($address)) {
        echo "All fields are required.";
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format.";
        exit;
    }

    // Calculate the total order amount
    $total = 0;
    foreach ($_SESSION['cart'] as $item) {
        $total += $item['quantity'] * $item['price'];
    }

    // Begin transaction
    $conn->begin_transaction();

    try {
        // Insert order details
        $stmt = $conn->prepare("INSERT INTO orders (user_id, customer_name, customer_email, customer_address, total) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("isssd", $user_id, $name, $email, $address, $total);

        if (!$stmt->execute()) {
            throw new Exception("Order insertion failed: " . $stmt->error);
        }

        $order_id = $stmt->insert_id;

        // Insert order items
        $itemStmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, product_name, quantity, price) VALUES (?, ?, ?, ?, ?)");
        foreach ($_SESSION['cart'] as $item) {
            $itemStmt->bind_param("iisid", $order_id, $item['id'], $item['name'], $item['quantity'], $item['price']);
            if (!$itemStmt->execute()) {
                throw new Exception("Order item insertion failed: " . $itemStmt->error);
            }
        }

        // Commit transaction
        $conn->commit();

        echo "<h2>Checkout Successful</h2>";
        echo "Thank you, <strong>" . htmlspecialchars($name, ENT_QUOTES, 'UTF-8') . "</strong>. Your order ID is <strong>$order_id</strong>.<br>Total: ₹$total";

        // Clear the cart
        unset($_SESSION['cart']);
    } catch (Exception $e) {
        // Rollback transaction in case of error
        $conn->rollback();
        echo "Checkout failed: " . $e->getMessage();
    } finally {
        // Close prepared statements and database connection
        $stmt->close();
        $itemStmt->close();
        $conn->close();
    }
} else {
    echo "Invalid request.";
}
?>
