<?php
$conn = new mysqli("localhost", "root", "", "music", 3307); // Use your database name here

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
