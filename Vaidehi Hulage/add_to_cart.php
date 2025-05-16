<?php
session_start();
include 'cart.php';

// Example usage
$userId = $_SESSION['user_id']; // Assume user is logged in
addToCartDB($userId, 101, 'Football', 25.00, 1);

header("Location: view_cart.php");
?>
