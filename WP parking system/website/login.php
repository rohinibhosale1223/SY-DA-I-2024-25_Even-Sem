<?php
// login.php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: signup.html");
    exit();
}

$username = trim($_POST['username']);
$pass = $_POST['pass'];

try {
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($pass, $user['password'])) {
        $_SESSION['user'] = [
            'username' => $user['username'],
            'firstname' => $user['firstname'],
            'lastname' => $user['lastname']
        ];
        header("Location: dashboard.php");
        exit();
    } else {
        $_SESSION['errors'] = ["Invalid username or password"];
        header("Location: signup.html");
        exit();
    }
} catch(PDOException $e) {
    error_log("Login error: " . $e->getMessage());
    $_SESSION['errors'] = ["Login failed. Please try again."];
    header("Location: signup.html");
    exit();
}
?>