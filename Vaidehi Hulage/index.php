<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home | Sports Gear Shop</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <div class="logo">Sports Gear Shop</div>
        <nav>
            <ul>
                <li><a href="products.php">Products</a></li>
                <li><a href="cart.php">Cart <span id="cart-count">(0)</span></a></li>
                <li><a href="about.php">About Us</a></li>
                <li><a href="contact.php">Contact</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="profile.php">Profile</a></li>
                    <li><a href="logout.php">Logout</a></li>
                <?php else: ?>
                    <li><a href="login.php">Login</a></li>
                    <li><a href="register.php">Register</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
    <main>
        <section class="banner">
            <h1>Welcome to Sports Gear Shop</h1>
            <?php if (isset($_SESSION['user_name'])): ?>
                <p>Hello, <strong><?php echo htmlspecialchars($_SESSION['user_name'], ENT_QUOTES, 'UTF-8'); ?></strong>! Explore our premium sports accessories.</p>
            <?php else: ?>
                <p>Your one-stop shop for premium sports accessories! Please <a href="login.php">log in</a> or <a href="register.php">register</a> to start shopping.</p>
            <?php endif; ?>
            <button><a href="products.php" aria-label="Shop Now">Shop Now</a></button>
        </section>
        <section class="featured-products">
            <h2>Featured Products</h2>
            <div class="product-grid">
                <div class="product-card">
                    <img src="images/gloves.jpg" alt="A pair of durable sports gloves for baseball">
                    <h3>Sports Gloves</h3>
                    <p>Durable and comfortable gloves for baseball.</p>
                    <p class="price">$25.00</p>
                </div>
                <div class="product-card">
                    <img src="images/bag.jpg" alt="A stylish sports bag designed to carry all your gear">
                    <h3>Sports Bag</h3>
                    <p>Stylish and spacious bags for your gear.</p>
                    <p class="price">$40.00</p>
                </div>
                <div class="product-card">
                    <img src="images/water-bottle.jpg" alt="An eco-friendly reusable water bottle">
                    <h3>Water Bottle</h3>
                    <p>Stay hydrated with our eco-friendly bottles.</p>
                    <p class="price">$15.00</p>
                </div>
            </div>
        </section>
    </main>
    <footer>
        <p>&copy; 2025 Sports Gear Accessories Shop. All rights reserved.</p>
    </footer>
</body>
</html>
