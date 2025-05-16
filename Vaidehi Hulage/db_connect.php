<?php
// Define database credentials as variables
$servername = "localhost";
$username = "root";
$password = "sure0405";
$dbname = "sportsgearshop";

// Create a database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
