<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');

// Debug: Check if request is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'error' => 'Invalid request method.']);
    exit;
}

$host = 'localhost';
$user = 'root';
$pass = 'tilak2005';  // use your real password
$db = 'blog_db';

$conn = new mysqli($host, $user, $pass, $db);

// Debug: Check connection
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'error' => 'DB connection failed: ' . $conn->connect_error]);
    exit;
}

// Get form data safely
$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$subject = $_POST['subject'] ?? '';
$phone = $_POST['phone'] ?? '';
$message = $_POST['message'] ?? '';

// Debug: Check missing fields
if (!$name || !$email || !$message) {
    echo json_encode(['success' => false, 'error' => 'Missing required fields.']);
    exit;
}

$stmt = $conn->prepare("INSERT INTO contact_form (name, email, subject, phone, message) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $name, $email, $subject, $phone, $message);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'Insert failed: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
