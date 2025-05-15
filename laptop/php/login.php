<?php
session_start();

// Database connection
$host = 'localhost';
$db   = 'laptop_shop'; // replace with your actual DB name
$user = 'root'; // default XAMPP user
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    die("Database Connection Failed: " . $e->getMessage());
}

// Get form data
$email = $_POST['email'];
$password = $_POST['password'];

// Check if email exists
$stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
$stmt->execute(['email' => $email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user && password_verify($password, $user['password'])) {
    // Store user details in localStorage via JavaScript on next page load
    echo "
    <script>
        localStorage.setItem('userDetails', JSON.stringify({
            username: '" . addslashes($user['name']) . "',
            email: '" . addslashes($user['email']) . "'
        }));
        window.location.href = 'index.html';
    </script>";
} else {
    echo "<script>alert('Invalid email or password.'); window.location.href = 'login.html';</script>";
}
?>
