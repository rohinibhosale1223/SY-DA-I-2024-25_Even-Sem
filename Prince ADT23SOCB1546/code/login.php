<?php
session_start();

$host = 'localhost';
$db   = 'healthcare_portal';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    die("Database Connection Failed: " . $e->getMessage());
}

$email = $_POST['email'];
$password = $_POST['password'];

$stmt = $pdo->prepare("SELECT * FROM patients WHERE email = :email");
$stmt->execute(['email' => $email]);
$patient = $stmt->fetch(PDO::FETCH_ASSOC);

if ($patient && password_verify($password, $patient['password'])) {
    $_SESSION['patientDetails'] = [
        'id' => $patient['id'],
        'name' => $patient['name'],
        'email' => $patient['email']
    ];
    echo "
    <script>
        localStorage.setItem('patientDetails', JSON.stringify({
            name: '" . addslashes($patient['name']) . "',
            email: '" . addslashes($patient['email']) . "'
        }));
        window.location.href = 'index.php';
    </script>";
} else {
    echo "<script>alert('Invalid email or password.'); window.location.href = 'login.html';</script>";
}
?>
