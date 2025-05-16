<?php
session_start();
include 'cart.php';

if (!isset($_SESSION['user_id'])) {
    // Redirect to login or show an error
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user_id'];

// Validate product_id
if (isset($_GET['product_id']) && is_numeric($_GET['product_id'])) {
    $productId = (int)$_GET['product_id']; // Cast to integer

    removeFromCartDB($userId, $productId);
} else {
    // Handle invalid product_id
    header("Location: view_cart.php?error=invalid_product");
    exit();
}

header("Location: view_cart.php");
exit();

function removeFromCartDB($userId, $productId) {
    global $conn;

    $stmt = $conn->prepare("DELETE FROM cart_items WHERE user_id = ? AND product_id = ?");
    if ($stmt) {
        $stmt->bind_param("ii", $userId, $productId);
        $stmt->execute();
        $stmt->close(); // Close the statement
    } else {
        // Handle error in preparing statement
        error_log("Database error: " . $conn->error);
    }
}
?>
