<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "music_db";

$conn = new mysqli($servername, $username, $password, $dbname, 3307);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id'];

// Fetch cart items including price
$stmt = $conn->prepare("SELECT track_name, quantity, price FROM cart WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$cart_items = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

if (empty($cart_items)) {
    echo "<p>Your cart is empty. Please add items before checkout.</p>";
    echo "<p><a href='cart.php'>Back to Cart</a></p>";
    exit();
}

$total_price = 0;
foreach ($cart_items as $item) {
    $total_price += $item['quantity'] * $item['price'];
}

// Simulate order success by clearing the cart
$del_stmt = $conn->prepare("DELETE FROM cart WHERE user_id = ?");
$del_stmt->bind_param("i", $user_id);
$del_stmt->execute();
$del_stmt->close();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Checkout Complete - Artwave</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            text-align: center;
            padding: 40px;
            background-color: #fff;
            color: #422F48;
        }
        .message {
            font-size: 1.8rem;
            margin-bottom: 20px;
        }
        .item-list {
            max-width: 500px;
            margin: 0 auto 30px;
            text-align: left;
        }
        .item-list ul {
            list-style-type: none;
            padding: 0;
        }
        .item-list li {
            padding: 8px 0;
            border-bottom: 1px solid #ddd;
        }
        .total {
            font-size: 1.5rem;
            margin-top: 20px;
            color: #311f36;
        }
        a.button {
            text-decoration: none;
            padding: 12px 30px;
            background-color: #422F48;
            color: white;
            border-radius: 8px;
            font-size: 1rem;
        }
        a.button:hover {
            background-color: #311f36;
        }
    </style>
</head>
<body>
    <div class="message">
        <p>Thank you for your purchase! Your order has been placed successfully.</p>
    </div>

    <div class="item-list">
        <h3>Order Summary:</h3>
        <ul>
            <?php foreach ($cart_items as $item): ?>
                <li>
                    <?php echo htmlspecialchars($item['track_name']); ?> (x<?php echo $item['quantity']; ?>)
                    - ₹<?php echo number_format($item['quantity'] * $item['price'], 2); ?>
                </li>
            <?php endforeach; ?>
        </ul>

        <div class="total">
            Total Paid: ₹<?php echo number_format($total_price, 2); ?>
        </div>
    </div>

    <a href="index.php" class="button">Back to Home</a>
</body>
</html>
