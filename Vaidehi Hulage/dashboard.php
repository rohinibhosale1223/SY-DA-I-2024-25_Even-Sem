<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION["user_id"])) {
    // Display an error message and link to the login page
    echo "<h2>Access Denied</h2>";
    echo "<p>Please <a href='login.html'>login</a> to access your account.</p>";
    exit();
}

// Sanitize user data before displaying
$user_name = htmlspecialchars($_SESSION["user_name"] ?? '', ENT_QUOTES, 'UTF-8');
$user_email = htmlspecialchars($_SESSION["user_email"] ?? '', ENT_QUOTES, 'UTF-8');

// Display user information and welcome message
echo "<h2>Welcome back, $user_name!</h2>";
echo "<p>You are logged in with email: $user_email</p>";
echo "<p>Start shopping for your favorite sports gear now!</p>";
echo "<a href='logout.php'>Logout</a>";
?>
