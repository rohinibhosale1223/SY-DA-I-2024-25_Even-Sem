<?php
$servername = "localhost";
$username = "root";   // XAMPP मध्ये default user
$password = "";       // XAMPP मध्ये default पासवर्ड रिकामा असतो
$dbname = "tourism";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
