<?php 
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the cart is set and not empty
    if (empty($_SESSION['cart'])) {
        echo "Your cart is empty!";
        exit;
    }

    // Capture and sanitize user inputs
    $name = htmlspecialchars(trim($_POST['name'] ?? ''), ENT_QUOTES, 'UTF-8');
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
    $address = htmlspecialchars(trim($_POST['address'] ?? ''), ENT_QUOTES, 'UTF-8');

    // Validate inputs
    if (empty($name) || empty($email) || empty($address)) {
        echo "Please fill in all required fields.";
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format.";
        exit;
    }

    // Display order summary
    echo "<h2>Order Summary</h2>";
    $total = 0;
    foreach ($_SESSION['cart'] as $item) {
        $itemName = htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8');
        $itemQuantity = intval($item['quantity']);
        $itemPrice = number_format(floatval($item['price']), 2);
        echo "$itemName - Qty: $itemQuantity - ₹$itemPrice<br>";
        $total += $itemQuantity * floatval($item['price']);
    }

    $totalFormatted = number_format($total, 2);
    echo "<p>Total: ₹$totalFormatted</p>";
    echo "<p>Thank you, " . htmlspecialchars($name, ENT_QUOTES, 'UTF-8') . "! Your order has been placed.</p>";

    // Clear the cart
    unset($_SESSION['cart']);
} else {
    echo "Invalid request method.";
}
?>
