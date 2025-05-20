<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "weather_app"; // ✅ Replace with your actual DB name

$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
