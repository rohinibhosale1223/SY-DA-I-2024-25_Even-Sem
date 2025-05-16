<?php
// 1. Grab POSTed values (always sanitize/validate in real apps!)
$firstname = $_POST['firstname'] ?? '';
$lastname  = $_POST['lastname']  ?? '';
$username  = $_POST['username']  ?? '';
$email     = $_POST['email']     ?? '';
$pass      = $_POST['pass']      ?? '';

// 2. Hash the password
$hashedPass = password_hash($pass, PASSWORD_DEFAULT);

// 3. Connect to MySQL
$conn = new mysqli("localhost", "root", "", "registration");


if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// 4. Prepare & bind
$stmt = $conn->prepare(
    "INSERT INTO `register` 
     (firstname, lastname, username, email, pass) 
     VALUES (?, ?, ?, ?, ?)"
);
$stmt->bind_param(
    "sssss", 
    $firstname, $lastname, $username, $email, $hashedPass
);

// 5. Execute & check
if ($stmt->execute()) {
    echo "Registration successful!";
    // Optionally: header('Location: loginpage.html');
} else {
    echo "Error: " . $stmt->error;
}

// 6. Close
$stmt->close();
$conn->close();
?>
