<?php
// php/cart.php
include 'db_connect.php';
session_start();

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(["error" => "User not authenticated."]);
    exit();
}

$user_id = $_SESSION['user_id'];

switch ($_GET['action']) {
    case 'add':
        $product_id = $_POST['product_id'];
        $quantity = $_POST['quantity'];

        $stmt = $conn->prepare("REPLACE INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)");
        $stmt->bind_param("iii", $user_id, $product_id, $quantity);
        $stmt->execute();
        echo json_encode(["success" => true]);
        break;

    case 'view':
        $stmt = $conn->prepare("SELECT p.name, p.price, c.quantity FROM cart c JOIN products p ON c.product_id = p.id WHERE c.user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $cart = [];
        while ($row = $result->fetch_assoc()) {
            $cart[] = $row;
        }
        echo json_encode($cart);
        break;

    case 'remove':
        $product_id = $_POST['product_id'];
        $stmt = $conn->prepare("DELETE FROM cart WHERE user_id = ? AND product_id = ?");
        $stmt->bind_param("ii", $user_id, $product_id);
        $stmt->execute();
        echo json_encode(["success" => true]);
        break;

    default:
        echo json_encode(["error" => "Invalid action."]);
        break;
}
?>
