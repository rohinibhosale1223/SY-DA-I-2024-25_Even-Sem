<?php
session_start();
$conn = new mysqli("localhost", "zkapoor", "Z.kapoor", "ziasy");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['cart']) || count($_SESSION['cart']) === 0) {
    echo "<p>Your cart is empty. <a href='home.php'>Go back</a></p>";
    exit;
}

// Save cart items to DB (optional step)
$session_id = session_id();
foreach ($_SESSION['cart'] as $item) {
    $name = $conn->real_escape_string($item['name']);
    $price = (int)$item['price'];
    $conn->query("INSERT INTO orders (session_id, product_name, price) VALUES ('$session_id', '$name', $price)");
}

// Clear cart
$_SESSION['cart'] = [];

?>
<!DOCTYPE html>
<html>
<head>
    <title>Checkout - Green Tours</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php
session_start();
?>
<div class="navbar">
    <a href="home.php">Home</a>
    <a href="about.php">About Us</a>

    <?php if (!isset($_SESSION['user_email'])): ?>
        <a href="register.php">Register</a>
        <a href="login.php">Login</a>
    <?php else: ?>
        <span style="color:white; padding:14px 20px;">Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
        <a href="logout.php" onclick="return confirm('Are you sure you want to log out?')">Logout</a>
    <?php endif; ?>

    <a href="cart.php" class="cart">Cart(<?php echo isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0; ?>)</a>
</div>


    <div class="content">
        <h2>Checkout Complete</h2>
        <p>Thank you! Your order has been placed successfully.</p>
        <a href="home.php">Continue Shopping</a>
    </div>
</body>
</html>
