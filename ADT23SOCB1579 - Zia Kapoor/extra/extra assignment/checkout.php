<?php
session_start();
include("navbar.php");
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Checkout</title>
</head>
<body>
<div class="content">
    <h2>Thank You!</h2>
    <p>Your order has been placed successfully.</p>
</div>
<?php
unset($_SESSION["cart"]);
?>
</body>
</html>
