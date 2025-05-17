<?php
$host = 'localhost';
$db   = 'healthcare_portal';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

try {
    $pdo = new PDO($dsn, $user, $pass);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit;
}

$name     = $_POST['name'];
$email    = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$phone    = $_POST['phone'];

$stmt = $pdo->prepare("SELECT * FROM patients WHERE email = :email");
$stmt->execute(['email' => $email]);
if ($stmt->rowCount() > 0) {
    echo "Email already registered.";
    exit;
}

$stmt = $pdo->prepare("INSERT INTO patients (name, email, password, phone) VALUES (:name, :email, :password, :phone)");
$stmt->execute([
    'name' => $name,
    'email' => $email,
    'password' => $password,
    'phone' => $phone
]);

header("Location: login.html");
exit;
?>
