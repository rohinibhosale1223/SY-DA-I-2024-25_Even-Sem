<?php
session_start();
include 'db_connect.php';

function addToCartDB($userId, $productId, $productName, $price, $quantity) {
    global $conn;

    try {
        // Validate inputs
        if (!is_numeric($userId) || !is_numeric($productId) || !is_numeric($price) || !is_numeric($quantity)) {
            throw new Exception("Invalid input data types.");
        }

        // Check if item already exists in the cart
        $stmt = $conn->prepare("SELECT id, quantity FROM cart_items WHERE user_id = ? AND product_id = ?");
        if (!$stmt) {
            throw new Exception("Failed to prepare SELECT query: " . $conn->error);
        }
        $stmt->bind_param("ii", $userId, $productId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Update quantity if item exists
            $row = $result->fetch_assoc();
            $newQuantity = $row['quantity'] + $quantity;

            $updateStmt = $conn->prepare("UPDATE cart_items SET quantity = ? WHERE id = ?");
            if (!$updateStmt) {
                throw new Exception("Failed to prepare UPDATE query: " . $conn->error);
            }
            $updateStmt->bind_param("ii", $newQuantity, $row['id']);
            $updateStmt->execute();
            $updateStmt->close();
        } else {
            // Insert new item
            $insertStmt = $conn->prepare("INSERT INTO cart_items (user_id, product_id, product_name, price, quantity) VALUES (?, ?, ?, ?, ?)");
            if (!$insertStmt) {
                throw new Exception("Failed to prepare INSERT query: " . $conn->error);
            }
            $insertStmt->bind_param("iisdi", $userId, $productId, $productName, $price, $quantity);
            $insertStmt->execute();
            $insertStmt->close();
        }

        $stmt->close();
    } catch (Exception $e) {
        error_log("Error in addToCartDB: " . $e->getMessage());
        echo "An error occurred while adding to the cart. Please try again.";
    }
}
?>
