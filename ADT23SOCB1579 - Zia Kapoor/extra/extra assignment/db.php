<?php
$servername = "localhost";
$username = "Piyush";
$password = "Admin";
$dbname = "resturant";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
