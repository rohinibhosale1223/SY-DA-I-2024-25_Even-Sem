<?php
session_start();
$conn = new mysqli("localhost", "zkapoor", "Z.kapoor", "ziasy");

// Check if the session has products
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array(); // Initialize cart if not set
}

// Add items to the cart from the form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['product_name']) && isset($_POST['product_price'])) {
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];

    // Check if the product is already in the cart, if not, add it
    $_SESSION['cart'][] = ['name' => $product_name, 'price' => $product_price];
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Your Cart - Green Tours</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

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
        <h2>Your Cart</h2>
        
        <?php
        if (empty($_SESSION['cart'])) {
            echo "<p>Your cart is empty.</p>";
        } else {
            echo "<ul>";
            $total = 0;
            foreach ($_SESSION['cart'] as $item) {
                echo "<li>" . htmlspecialchars($item['name']) . " - ₹" . htmlspecialchars($item['price']) . "</li>";
                $total += $item['price'];
            }
            echo "</ul>";
            echo "<strong>Total: ₹$total</strong>";
        }
        ?>

        <form action="checkout.php" method="post">
            <input type="submit" value="Checkout" <?php echo empty($_SESSION['cart']) ? 'disabled' : ''; ?>>
        </form>
    </div>
</body>
</html>
