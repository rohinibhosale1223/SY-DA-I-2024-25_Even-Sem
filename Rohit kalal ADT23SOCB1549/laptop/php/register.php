<?php
include 'db.php';

$name = $_POST['name'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_BCRYPT);
$phone = $_POST['phone'];

// Check if email already exists
$sql_check = "SELECT * FROM users WHERE email='$email'";
$result = $conn->query($sql_check);

if ($result->num_rows > 0) {
    echo "Email already registered!";
} else {
    $sql = "INSERT INTO users (name, email, password, phone)
            VALUES ('$name', '$email', '$password', '$phone')";
    
    if ($conn->query($sql) === TRUE) {
        echo "Registration successful!";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
