<?php
session_start();
$conn = new mysqli("localhost", "zkapoor", "Z.kapoor", "ziasy");

$name = $_POST['name'];
$price = $_POST['price'];
$session_id = session_id();

$conn->query("INSERT INTO cart (session_id, product_name, price) VALUES ('$session_id', '$name', '$price')");
header("Location: home.php");
?>
