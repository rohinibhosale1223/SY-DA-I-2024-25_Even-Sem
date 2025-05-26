<!DOCTYPE html>
<html>
<head>
    <title>Login - Green Tours</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php
session_start();
?>
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
        <h2>Login</h2>
        <form method="post">
            Email: <input type="email" name="email" required><br>
            Password: <input type="password" name="password" required><br>
            <input type="submit" value="Login">
        </form>
    </div>
</body>
</html>

<?php
session_start();
$conn = new mysqli("localhost", "zkapoor", "Z.kapoor", "ziasy");
if ($conn->connect_error) die("Connection failed");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $res = $conn->query("SELECT * FROM users WHERE email='$email'");
    $user = $res->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = $user['name'];
        header("Location: home.php");
    } else {
        echo "Invalid credentials";
    }
}
?>
