<?php 
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "music_db";

$conn = new mysqli($servername, $username, $password, $dbname, 3307);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id'];

// Handle item removal
if (isset($_POST['remove_track_name']) && isset($_POST['remove_type'])) {
    $remove_name = $conn->real_escape_string($_POST['remove_track_name']);
    $remove_type = $conn->real_escape_string($_POST['remove_type']);
    $stmt_remove = $conn->prepare("DELETE FROM cart WHERE user_id = ? AND track_name = ? AND type = ? LIMIT 1");
    $stmt_remove->bind_param("iss", $user_id, $remove_name, $remove_type);
    $stmt_remove->execute();
    $stmt_remove->close();
    header("Location: cart.php");
    exit();
}

// Fetch cart items with price
$stmt = $conn->prepare("SELECT track_name, track_url, quantity, type, price FROM cart WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($name, $url, $quantity, $type, $price);

$music_items = [];
$artwork_items = [];
$subtotal = 0;

while ($stmt->fetch()) {
    $item_total = $quantity * $price;
    $subtotal += $item_total;
    $item = ['name' => $name, 'url' => $url, 'quantity' => $quantity, 'price' => $price];
    if ($type === 'music') {
        $music_items[] = $item;
    } elseif ($type === 'artwork') {
        $artwork_items[] = $item;
    }
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Your Cart - Artwave</title>
  <link rel="stylesheet" href="style.css" />
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #ffffff;
      color: #422F48;
      margin: 0;
      padding: 0;
      text-align: center;
    }

    .cart-container {
      margin-top: 60px;
      padding: 30px 20px;
    }

    .navbar {
      display: flex;
      justify-content: center;
      background-color: #412E46;
      padding: 18px 0;
      gap: 30px;
      position: sticky;
      top: 0;
      z-index: 999;
    }

    .navbar a {
      text-decoration: none;
      color: #fcf3ff;
      font-weight: 500;
      font-size: 18px;
      transition: color 0.3s ease;
    }

    .navbar a:hover {
      color: #7b4b94;
    }

    .cart-header {
      font-size: 2.5rem;
      color: #422F48;
    }

    .cart-items {
      display: flex;
      justify-content: center;
      gap: 20px;
      margin-top: 30px;
      flex-wrap: wrap;
      padding: 0 20px;
      max-height: 500px;
      overflow-y: auto;
    }

    .cart-items::-webkit-scrollbar {
      width: 10px;
    }

    .cart-items::-webkit-scrollbar-track {
      background: #f1f1f1;
      border-radius: 10px;
    }

    .cart-items::-webkit-scrollbar-thumb {
      background-color: #422F48;
      border-radius: 10px;
    }

    .cart-item {
      background-color: #422F48;
      border-radius: 20px;
      padding: 20px;
      width: 300px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      display: flex;
      flex-direction: column;
      align-items: center;
      color: white;
      position: relative;
    }

    .cart-item-title {
      font-size: 1.2rem;
      margin-bottom: 10px;
    }

    audio, img.artwork {
      width: 100%;
      margin-top: 10px;
      border-radius: 10px;
    }

    .remove-btn {
      position: absolute;
      top: 15px;
      right: 15px;
      background: #ff4c4c;
      border: none;
      border-radius: 50%;
      width: 28px;
      height: 28px;
      color: white;
      font-weight: bold;
      cursor: pointer;
      line-height: 28px;
      font-size: 16px;
    }

    .checkout-btn {
      padding: 12px 25px;
      background-color: #422F48;
      color: rgb(255, 255, 255);
      border: none;
      border-radius: 8px;
      cursor: pointer;
      margin-top: 40px;
      font-size: 1rem;
    }

    .checkout-btn:hover {
      background-color: #311f36;
    }

    footer {
      margin-top: 60px;
      padding: 20px;
      font-size: 0.9rem;
      color: #888;
    }
  </style>
</head>
<body>

  <!-- Logo -->
  <div class="logo">
    <img src="logo.artwave.png" alt="Artwave Logo" />
  </div>

  <!-- Navigation Bar -->
  <nav class="navbar">
    <a href="index.php">Home</a>
    <a href="menu.php">Menu</a>
    <a href="about.php">About</a>
    <a href="contact.php">Contact</a>
    <a href="register.php">Register</a>
    <a href="login.php">Login</a>
    <a href="cart.php">Cart</a>
  </nav>

  <div class="cart-container">
    <h1 class="cart-header">Your Cart</h1>

    <div class="cart-items">
      <?php
        if (empty($music_items) && empty($artwork_items)) {
            echo "<p>Your cart is empty!</p>";
        }

        foreach ($music_items as $track) {
            echo "<div class='cart-item'>";
            echo "<div class='cart-item-title'>" . htmlspecialchars($track['name']) . " (x" . htmlspecialchars($track['quantity']) . ")</div>";
            echo "<p>Price: ₹" . number_format($track['price'], 2) . "</p>";
            echo "<audio controls><source src='" . htmlspecialchars($track['url']) . "' type='audio/mpeg'></audio>";
            echo "<form method='post' style='position:absolute; top:0; right:0;'>";
            echo "<input type='hidden' name='remove_track_name' value='" . htmlspecialchars($track['name'], ENT_QUOTES) . "'>";
            echo "<input type='hidden' name='remove_type' value='music'>";
            echo "<button type='submit' class='remove-btn' title='Remove item'>&times;</button>";
            echo "</form>";
            echo "</div>";
        }

        foreach ($artwork_items as $art) {
            echo "<div class='cart-item'>";
            echo "<div class='cart-item-title'>" . htmlspecialchars($art['name']) . " (x" . htmlspecialchars($art['quantity']) . ")</div>";
            echo "<p>Price: ₹" . number_format($art['price'], 2) . "</p>";
            echo "<img class='artwork' src='" . htmlspecialchars($art['url']) . "' alt='Artwork'>";
            echo "<form method='post' style='position:absolute; top:0; right:0;'>";
            echo "<input type='hidden' name='remove_track_name' value='" . htmlspecialchars($art['name'], ENT_QUOTES) . "'>";
            echo "<input type='hidden' name='remove_type' value='artwork'>";
            echo "<button type='submit' class='remove-btn' title='Remove item'>&times;</button>";
            echo "</form>";
            echo "</div>";
        }
      ?>
    </div>

    <?php if ($subtotal > 0): ?>
      <h2 style="margin-top: 40px; color: #422F48;">Subtotal: ₹<?php echo number_format($subtotal, 2); ?></h2>
    <?php endif; ?>

    <form action="checkout.php" method="post" style="margin-top:40px;">
      <button type="submit" class="checkout-btn">Proceed to Checkout</button>
    </form>
  </div>

  <footer>
    &copy; 2025 Artwave. All rights reserved.
  </footer>

</body>
</html>
