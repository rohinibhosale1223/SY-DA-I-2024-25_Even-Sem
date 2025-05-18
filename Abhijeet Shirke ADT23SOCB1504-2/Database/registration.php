<?php
// Database connection parameters
$servername = "localhost";
$username = "abhijeet61";   // XAMPP मध्ये root user default आहे
$password = "abhijeet";       // XAMPP मध्ये default पासवर्ड रिकामा असतो
$dbname = "tourism_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get POST data and sanitize
$name = $conn->real_escape_string($_POST['name']);
$email = $conn->real_escape_string($_POST['email']);
$password = $_POST['password'];

// Basic validation (Optional, can improve)
if (empty($name) || empty($email) || empty($password)) {
    die("Please fill all required fields.");
}

// Hash the password for security
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Check if email already exists
$sql_check = "SELECT * FROM users WHERE email='$email'";
$result = $conn->query($sql_check);
if ($result->num_rows > 0) {
    die("This email is already registered. Please use another email.");
}

// Insert into database
$sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$hashed_password')";

if ($conn->query($sql) === TRUE) {
    echo "Registration successful! You can now <a href='login.html'>login</a>.";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>
