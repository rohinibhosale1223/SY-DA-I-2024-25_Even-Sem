<?php
session_start();
include 'config.php';

$user_id = 1; // dummy user, नंतर login user id द्यायचा

// Add to Cart
if (isset($_POST['add_to_cart'])) {
    $item_name = $_POST['item_name'];
    $quantity = intval($_POST['quantity']);
    $price = floatval($_POST['price']);

    $check_sql = "SELECT * FROM cart WHERE user_id=? AND item_name=?";
    $stmt = $conn->prepare($check_sql);
    $stmt->bind_param("is", $user_id, $item_name);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $update_sql = "UPDATE cart SET quantity = quantity + ? WHERE user_id=? AND item_name=?";
        $stmt = $conn->prepare($update_sql);
        $stmt->bind_param("iis", $quantity, $user_id, $item_name);
        $stmt->execute();
    } else {
        $insert_sql = "INSERT INTO cart (user_id, item_name, quantity, price) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($insert_sql);
        $stmt->bind_param("isid", $user_id, $item_name, $quantity, $price);
        $stmt->execute();
    }
    header("Location: cart.php");
    exit();
}

// Remove from Cart
if (isset($_GET['remove'])) {
    $id = intval($_GET['remove']);
    $delete_sql = "DELETE FROM cart WHERE id=? AND user_id=?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("ii", $id, $user_id);
    $stmt->execute();
    header("Location: cart.php");
    exit();
}

// Fetch Cart Items
$sql = "SELECT * FROM cart WHERE user_id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$cart_items = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tourism Cart</title>
</head>
<body>
    <h2>Tourism Cart</h2>

    <form method="POST" action="cart.php">
        <input type="text" name="item_name" placeholder="Item Name" required>
        <input type="number" name="quantity" placeholder="Quantity" min="1" required>
        <input type="text" name="price" placeholder="Price" required>
        <button type="submit" name="add_to_cart">Add to Cart</button>
    </form>

    <h3>Your Cart</h3>
    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>Item</th>
            <th>Quantity</th>
            <th>Price Per Item</th>
            <th>Total Price</th>
            <th>Action</th>
        </tr>
        <?php 
        $grand_total = 0;
        while ($row = $cart_items->fetch_assoc()) { 
            $total = $row['quantity'] * $row['price'];
            $grand_total += $total;
        ?>
        <tr>
            <td><?php echo htmlspecialchars($row['item_name']); ?></td>
            <td><?php echo $row['quantity']; ?></td>
            <td><?php echo number_format($row['price'], 2); ?></td>
            <td><?php echo number_format($total, 2); ?></td>
            <td><a href="cart.php?remove=<?php echo $row['id']; ?>" onclick="return confirm('Remove this item?')">Remove</a></td>
        </tr>
        <?php } ?>
        <tr>
            <td colspan="3"><strong>Grand Total</strong></td>
            <td colspan="2"><strong><?php echo number_format($grand_total, 2); ?></strong></td>
        </tr>
    </table>

    <form action="checkout.php" method="POST">
        <button type="submit">Checkout Now</button>
    </form>
</body>
</html>
