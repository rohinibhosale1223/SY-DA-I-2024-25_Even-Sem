<?php
$conn = new mysqli("localhost", "Manthan", "Manmrun@0019", "sneaker_sphere");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$fullname = $_POST['fullname'] ?? '';
$gender = $_POST['gender'] ?? '';
$address = $_POST['address'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';
$confirm_password = $_POST['confirm_password'] ?? '';
$role = $_POST['role'] ?? 'user';

if ($password !== $confirm_password) {
    die("Passwords do not match.");
}

$sql = "INSERT INTO users (fullname, gender, address, email, password, role) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssss", $fullname, $gender, $address, $email, $password, $role);

if ($stmt->execute()) {
    echo "Registration successful. <a href='login.html'>Login Now</a>";
} else {
    echo "Error: " . $stmt->error;
}

$conn->close();
?>
