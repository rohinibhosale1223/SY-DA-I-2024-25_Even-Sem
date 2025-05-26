<?php
session_start();
$conn = new mysqli("localhost", "zkapoor", "Z.kapoor", "ziasy");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password === $confirm_password) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO users (name, contact_no, email, password) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $contact, $email, $hashedPassword);

        if ($stmt->execute()) {
            // Save user session
            $_SESSION['user_email'] = $email;
            $_SESSION['user_name'] = $name;

            echo "<script>
                alert('Registration successful! You are now logged in.');
                window.location.href = 'home.php';
            </script>";
            exit();
        } else {
            echo "<script>alert('Error: Email may already be registered.');</script>";
        }
    } else {
        echo "<script>alert('Passwords do not match!');</script>";
    }
}
?>




<!DOCTYPE html>
<html>
<head>
    <title>Register - Green Tours</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="navbar">
    <a href="home.php">Home</a>
    <a href="about.php">About Us</a>

    <?php if (!isset($_SESSION['user_email'])): ?>
        <a href="register.php">Register</a>
        <a href="login.php">Login</a>
    <?php else: ?>
        <span style="color:white; padding:14px 20px;">Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
        <a href="logout.php" onclick="return confirm('Are you sure you want to log out?')">Logout</a>
    <?php endif; ?>

    <a href="cart.php" class="cart">Cart(<?php echo isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0; ?>)</a>
</div>
   

    <div class="content">
        <h2>Register</h2>
        <form method="post">
            Name: <input type="text" name="name" required><br>
            Contact No: <input type="text" name="contact" required><br>
            Email: <input type="email" name="email" required><br>
            Password: <input type="password" name="password" required><br>
            Confirm Password: <input type="password" name="confirm_password" required><br>
            <input type="submit" value="Register">
        </form>
    </div>
</body>
</html>
	