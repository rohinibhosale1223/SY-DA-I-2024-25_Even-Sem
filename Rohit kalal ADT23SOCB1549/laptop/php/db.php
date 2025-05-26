<?php
$host = "localhost";
$user = "root"; // update if using a different username
$password = ""; // update if your MySQL has a password
$database = "laptop_shop"; // name of your DB

$conn = new mysqli($host, $user, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
