<?php
$host = "localhost";
$dbname = "weather_app";  // ensure correct spelling & case
$dbuser = "root";
$dbpass = "";

// Create DB connection
$conn = new mysqli($host, $dbuser, $dbpass, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Sanitize inputs
$username = htmlspecialchars(trim($_POST["username"]));
$password = trim($_POST["password"]);

// Basic validation
if (empty($username) || empty($password)) {
    die("Please fill in all fields. <a href='register.html'>Go back</a>");
}

// Check if username exists
$stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
if (!$stmt) {
    die("SQL prepare failed (check users table): " . $conn->error);
}
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    echo "Username already exists. <a href='register.html'>Try another</a>";
    $stmt->close();
    $conn->close();
    exit();
}
$stmt->close();

// Insert new user with hashed password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);
$stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
if (!$stmt) {
    die("SQL prepare failed (insert): " . $conn->error);
}
$stmt->bind_param("ss", $username, $hashed_password);

if ($stmt->execute()) {
    echo "Registration successful. <a href='index.html'>Login here</a>";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
