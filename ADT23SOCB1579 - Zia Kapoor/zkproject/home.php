<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Green Tours - Home</title>
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
      <h1>Welcome to Green Tours</h1>
<p>Explore our curated travel experiences:</p>

<p>
    At <strong>Green Tours</strong>, we are passionate about redefining the way you travel. Our mission is to promote eco-friendly, sustainable, and culturally rich tourism across India. We believe that travel should not only be about sightseeing — it should be about connecting with nature, respecting local cultures, and leaving a positive impact.
</p>

<p>
    Our carefully crafted tour packages take you to some of the most beautiful and untouched destinations in the country — from the calm backwaters of Kerala to the adventurous terrains of Ladakh, and the vibrant traditions of Rajasthan to the serene beauty of the North East.
</p>

<p>
    Why travel with Green Tours?
</p>

<ul>
    <li>🌿 Eco-conscious accommodations and transport</li>
    <li>🌏 Immersive experiences with local communities</li>
    <li>🧭 Guided nature treks, heritage walks, and wildlife tours</li>
    <li>🍃 Small group sizes for a more personalized and mindful journey</li>
</ul>

<p>
    Whether you're an adventure seeker, a nature lover, or a cultural explorer, Green Tours has the perfect journey waiting for you. Start exploring today and be a part of the green travel revolution!
</p>


    <?php
$products = [
    ['name' => 'Goa Beach Tour', 'price' => 7999, 'img' => 'goa.jpg'],
    ['name' => 'Manali Adventure Trip', 'price' => 8999, 'img' => 'manali.jpg'],
    ['name' => 'Kerala Backwaters', 'price' => 9999, 'img' => 'kerala.jpg'],
    ['name' => 'Rajasthan Heritage Tour', 'price' => 8499, 'img' => 'rajasthan.jpg'],
    ['name' => 'North East Explorer', 'price' => 10500, 'img' => 'northeast.jpg'],
    ['name' => 'Ladakh Bike Ride', 'price' => 11999, 'img' => 'ladakh.jpg']
];

// Shuffle to randomize product order
shuffle($products);

// Display 3 random products
foreach (array_slice($products, 0, 6) as $product) {
    echo '<div class="product" style="border: 1px solid #ccc; padding: 15px; border-radius: 10px; margin: 10px; width: 250px; background-color: #f0fff0;">';
    
    echo '<img src="' . htmlspecialchars($product['img']) . '" alt="' . htmlspecialchars($product['name']) . '" style="width: 100%; height: 160px; object-fit: cover; border-radius: 8px; margin-bottom: 10px;">';
    
    echo '<h3>' . htmlspecialchars($product['name']) . '</h3>';
    echo '<p>Price: ₹' . number_format($product['price']) . '</p>';
    
    echo '<form method="post" action="add_to_cart.php">';
    echo '<input type="hidden" name="name" value="' . htmlspecialchars($product['name']) . '">';
    echo '<input type="hidden" name="price" value="' . htmlspecialchars($product['price']) . '">';
    echo '<input type="submit" value="Add to Cart" style="background-color: #006400; color: white; padding: 8px 12px; border: none; border-radius: 5px;">';
    echo '</form>';
    
    echo '</div>';
}
?>

    </div>
    <footer style="background-color: #1b1b1b; color: #ffffff; padding: 20px 0; text-align: center; margin-top: 40px;">
    <div style="max-width: 1200px; margin: auto;">
        <p>&copy; 2025 Green Tours. All Rights Reserved.</p>
</body>
</html>
