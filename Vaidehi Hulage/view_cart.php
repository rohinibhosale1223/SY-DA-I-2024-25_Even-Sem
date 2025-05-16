<?php
session_start();
include 'cart.php';

if (!isset($_SESSION['user_id'])) {
    // Redirect to login or show an error
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user_id'];
viewCartDB($userId);

function viewCartDB($userId) {
    global $conn;

    $stmt = $conn->prepare("SELECT product_name, price, quantity FROM cart_items WHERE user_id = ?");
    if ($stmt) {
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            echo "<p>Your cart is empty.</p>";
            return;
        }

        echo "<h3>Your Cart:</h3>";
        while ($row = $result->fetch_assoc()) {
            $totalPrice = $row['quantity'] * $row['price'];
            echo "<p>{$row['product_name']} - {$row['quantity']} x \$" . number_format($row['price'], 2) . " = \$" . number_format($totalPrice, 2) . "</p>";
        }

        $stmt->close(); // Close the statement
    } else {
        // Handle error in preparing statement
        echo "<p>Error retrieving cart items. Please try again later.</p>";
        error_log("Database error: " . $conn->error);
    }
}
?>
