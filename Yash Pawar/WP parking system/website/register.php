<?php
// register.php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: signup.html");
    exit();
}

$first = trim($_POST['firstname']);
$last = trim($_POST['lastname']);
$username = trim($_POST['username']);
$pass = $_POST['pass'];

// Validate inputs
$errors = [];

if (empty($first)) $errors[] = "First name is required";
if (empty($last)) $errors[] = "Last name is required";
if (empty($username)) $errors[] = "Username is required";
if (empty($pass)) $errors[] = "Password is required";
if (strlen($username) < 6) $errors[] = "Username must be at least 6 characters";
if (strlen($pass) < 6) $errors[] = "Password must be at least 6 characters";

if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    header("Location: signup.html");
    exit();
}

try {
    // Check if username exists
    $stmt = $conn->prepare("SELECT username FROM users WHERE username = ?");
    $stmt->execute([$username]);
    
    if ($stmt->rowCount() > 0) {
        $_SESSION['errors'] = ["Username already taken"];
        header("Location: signup.html");
        exit();
    }

    // Hash the password
    $hashedPass = password_hash($pass, PASSWORD_DEFAULT);

    // Insert new user
    $stmt = $conn->prepare("INSERT INTO users (firstname, lastname, username, password) VALUES (?, ?, ?, ?)");
    $stmt->execute([$first, $last, $username, $hashedPass]);

    // Set session and redirect
    $_SESSION['user'] = [
        'username' => $username,
        'firstname' => $first,
        'lastname' => $last
    ];
    
    header("Location: dashboard.php");
    exit();

} catch(PDOException $e) {
    error_log("Registration error: " . $e->getMessage());
    $_SESSION['errors'] = ["Registration failed. Please try again."];
    header("Location: signup.html");
    exit();
}
?>