<?php
session_start();
include("navbar.php");
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Cart</title>
</head>
<body>
<div class="content">
    <h2>Your Cart</h2>
    <?php
    if (isset($_SESSION["cart"]) && count($_SESSION["cart"]) > 0) {
        $total = 0;
        foreach ($_SESSION["cart"] as $item) {
            echo "<p>" . $item["item"] . " - ₹" . $item["price"] . "</p>";
            $total += $item["price"];
        }
        echo "<h3>Total: ₹$total</h3>";
        echo '<a href="checkout.php"><input type="submit" value="Checkout"></a>';
    } else {
        echo "<p>Your cart is empty.</p>";
    }
    ?>
</div>
</body>
</html>
