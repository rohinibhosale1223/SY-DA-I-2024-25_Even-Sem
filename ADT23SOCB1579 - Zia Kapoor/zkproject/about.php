<!DOCTYPE html>
<html>
<head>
    <title>About Us - Green Tours</title>
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
    <h1>About Green Tours</h1>
<p>We provide eco-friendly tourism packages all over India.</p>
<p>At Green Tours, our mission is to promote responsible travel by offering sustainable and nature-friendly tour packages. We focus on minimizing the environmental impact while maximizing cultural and community engagement. Our tours include visits to eco-resorts, nature treks, wildlife sanctuaries, and heritage sites, ensuring a memorable and conscious travel experience.</p>
<p>We collaborate with local guides and communities to ensure authentic experiences and economic support to rural areas. Whether you're looking for a peaceful retreat in the Himalayas or a beachside eco-resort in Kerala, Green Tours has something for every eco-conscious traveler.</p>

<!-- Footer -->
<footer style="background-color: #1b1b1b; color: #ffffff; padding: 20px 0; text-align: center; margin-top: 40px;">
    <div style="max-width: 1200px; margin: auto;">
        <p>&copy; 2025 Green Tours. All Rights Reserved.</p>
    </div>
</body>
</html>
