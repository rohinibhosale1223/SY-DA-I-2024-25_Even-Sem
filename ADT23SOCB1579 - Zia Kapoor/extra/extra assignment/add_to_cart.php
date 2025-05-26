<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $item = $_POST["item"];
    $price = $_POST["price"];
    $product = array("item" => $item, "price" => $price);

    if (!isset($_SESSION["cart"])) {
        $_SESSION["cart"] = array();
    }

    array_push($_SESSION["cart"], $product);
    header("Location: cart.php");
    exit();
}
?>
