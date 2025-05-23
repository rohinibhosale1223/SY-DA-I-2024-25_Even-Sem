<?php
$servername = "localhost";
$username = "Manthan";       
$password = "Manmrun@0019";          
$database = "sneaker_sphere";

$conn = new mysqli($servername, $username, $password, $database);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
