<?php
// Database connection configuration

$host = "localhost";
$dbname = "modiwear_db";
$username = "root";  // change if your MySQL username is different
$password = "";      // change if you have a password for MySQL

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    // Set PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
