<?php
session_start();
include("db.php");
include("navbar.php");
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Home - Restaurant</title>
</head>
<body>
<div class="content">
    <h2>Welcome to Our Restaurant</h2>

    <div class="product">
        <h3>Margherita Pizza</h3>
        <p>Classic delight with mozzarella cheese</p>
        <p>₹250</p>
        <form method="post" action="add_to_cart.php">
            <input type="hidden" name="item" value="Margherita Pizza">
            <input type="hidden" name="price" value="250">
            <input type="submit" value="Add to Cart">
        </form>
    </div>

    <div class="product">
        <h3>Veggie Burger</h3>
        <p>Grilled patty with fresh veggies</p>
        <p>₹150</p>
        <form method="post" action="add_to_cart.php">
            <input type="hidden" name="item" value="Veggie Burger">
            <input type="hidden" name="price" value="150">
            <input type="submit" value="Add to Cart">
        </form>
    </div>
</div>
</body>
</html>
