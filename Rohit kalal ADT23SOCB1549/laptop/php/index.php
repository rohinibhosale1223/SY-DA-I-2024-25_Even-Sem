<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My E-Commerce Store - Home</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; text-align: center; }
        .navbar { background-color: #333; padding: 15px; }
        .navbar a { color: white; text-decoration: none; padding: 14px 20px; display: inline-block; }
        .navbar a:hover { background-color: #575757; }
        .hero { background-image: url('hero-image.jpg'); background-size: cover; background-position: center; color: white; padding: 100px 20px; }
        .hero h1 { font-size: 3em; margin: 0; }
        .hero p { font-size: 1.2em; margin: 10px 0 20px; }
        .button { background-color: #28a745; color: white; padding: 15px 20px; text-decoration: none; font-size: 1.2em; border-radius: 5px; }
        .button:hover { background-color: #218838; }
        .content { padding: 20px; }
        .categories { display: flex; justify-content: center; gap: 20px; margin-top: 20px; }
        .category { border: 1px solid #ddd; padding: 15px; width: 200px; }
        .footer { background-color: #333; color: white; padding: 20px; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="index.php">Home</a>
        <a href="product.php">Products</a>
        <a href="about.php">About Us</a>
        <a href="register.php">Login/Register</a>
        <a href="cart.php">Cart</a>
    </div>
    <div class="hero">
        <h1>Welcome to My E-Commerce Store</h1>
        <p>Your one-stop shop for the best products at the best prices.</p>
        <a href="product.php" class="button">Shop Now</a>
    </div>
    <div class="content">
        <h2>Why Shop With Us?</h2>
        <p>We offer a wide range of high-quality products at competitive prices. Fast shipping, easy returns, and excellent customer service make us your best choice.</p>
        <h2>Featured Categories</h2>
        <div class="categories">
            <div class="category"><h3>Electronics</h3><p>Latest gadgets and devices</p></div>
            <div class="category"><h3>Fashion</h3><p>Trendy apparel and accessories</p></div>
            <div class="category"><h3>Home Essentials</h3><p>Decor and furniture for every home</p></div>
        </div>
    </div>
    <div class="footer">
        <p>&copy; 2025 My E-Commerce Store. All rights reserved.</p>
        <p><a href="about.php" style="color: white;">About Us</a> | <a href="contact.php" style="color: white;">Contact</a> | <a href="privacy.php" style="color: white;">Privacy Policy</a></p>
    </div>

    <?php
    // Check if user is logged in and display appropriate message
    if (isset($_SESSION['userDetails'])) {
        $userDetails = $_SESSION['userDetails'];
        echo '<span id="welcome">Welcome, ' . htmlspecialchars($userDetails['username']) . '!</span>';
        echo '<a id="logout" href="logout.php">Logout</a>';
    } else {
        echo '<a id="login" href="login.php">Login</a>';
        echo '<a id="register" href="register.php"> | Register</a>';
    }
    ?>

    <script>
        // If needed for other client-side functionality
        // No longer needed for user details as PHP handles this
    </script>
</body>
</html>
