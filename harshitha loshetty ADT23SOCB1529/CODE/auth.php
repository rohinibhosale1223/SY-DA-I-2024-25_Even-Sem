<?php
session_start();

$host = "localhost";
$dbname = "weather_app";  // Make sure this matches your actual database name (lowercase)
$dbuser = "root";
$dbpass = "";

// Connect to database
$conn = new mysqli($host, $dbuser, $dbpass, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$username = htmlspecialchars(trim($_POST["username"]));
$password = trim($_POST["password"]);

if (empty($username) || empty($password)) {
    die("Please enter both username and password. <a href='index.html'>Try again</a>");
}

// Prepare the SQL statement
$stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
if (!$stmt) {
    die("SQL prepare failed: " . $conn->error);
}

$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 1) {
    $stmt->bind_result($hashed_password);
    $stmt->fetch();

    if (password_verify($password, $hashed_password)) {
        $_SESSION["username"] = $username;
        $stmt->close();
        $conn->close();
        header("Location: dashboard.php");
        exit();
    }
}

echo "Invalid credentials. <a href='index.html'>Try again</a>";

$stmt->close();
$conn->close();
?>
