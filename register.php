<?php
// Connect to your database (PDO example)
$host = 'localhost';
$db   = 'laptop_shop';
$user = 'root'; // default XAMPP user
$pass = '';
$charset = 'utf8mb4';
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

try {
    $pdo = new PDO($dsn, $user, $pass);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit;
}

// Get form data
$name     = $_POST['name'];
$email    = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$phone    = $_POST['phone'];

// Check if email already exists
$stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
$stmt->execute(['email' => $email]);
if ($stmt->rowCount() > 0) {
    echo "Email already registered.";
    exit;
}

// Insert user into database
$stmt = $pdo->prepare("INSERT INTO users (name, email, password, phone) VALUES (:name, :email, :password, :phone)");
$stmt->execute([
    'name' => $name,
    'email' => $email,
    'password' => $password,
    'phone' => $phone
]);

// ✅ Redirect to login page after successful registration
header("Location: login.html");
exit;
?>
