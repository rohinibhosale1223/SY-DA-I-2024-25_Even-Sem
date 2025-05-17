<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['appointment summary']) || empty($_SESSION['appointment summary'])) {
        echo "Your appointment summary is empty!";
        exit;
    }

    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $address = $_POST['address'] ?? '';

    if (empty($name) || empty($email) || empty($address)) {
        echo "Please fill in all required fields.";
        exit;
    }

    echo "<h2>Order Summary</h2>";
    $total = 0;
    foreach ($_SESSION['appointment summary'] as $item) {
        echo "{$item['name']} - Qty: {$item['quantity']} - ₹{$item['price']} <br>";
        $total += $item['quantity'] * $item['price'];
    }

    echo "<p>Total: ₹$total</p>";
    echo "<p>Thank you, $name! Your order has been placed.</p>";

    
    unset($_SESSION['appointment summary']);
} else {
    echo "Invalid request method.";
}
?>
