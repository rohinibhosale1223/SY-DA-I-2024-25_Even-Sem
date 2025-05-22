<?php
// Start the session
session_start();

// If the user is already logged in, redirect to the index page
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit(); // Stop further execution
}

include 'config.php'; // Database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirmPassword"];

    // Check if passwords match
    if ($password !== $confirmPassword) {
        echo "<script>alert('Passwords do not match.');</script>";
    } else {
        // Check if user already exists
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "<script>alert('Account with this email already exists.');</script>";
        } else {
            // Create new user
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
            $stmt->bind_param("ss", $email, $hashedPassword);
            if ($stmt->execute()) {
                echo "<script>alert('Registration successful!'); window.location.href='login.php';</script>";
            } else {
                echo "<script>alert('Something went wrong. Please try again.');</script>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Register - Artwave</title>
  <link rel="stylesheet" href="style.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f4f4f4;
      margin: 0;
      padding: 0;
      display: flex;
      flex-direction: column;
      align-items: center;
      min-height: 100vh;
    }

    .navbar {
      background-color: #422F48;
      padding: 15px;
      width: 100%;
      text-align: center;
    }

    .navbar a {
      color: white;
      margin: 0 4px;
      text-decoration: none;
      font-weight: 500;
    }

    .register-container {
      background: white;
      margin-top: 60px;
      padding: 40px 30px;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
      max-width: 400px;
      width: 90%;
      text-align: center;
    }

    .register-container h2 {
      color: #422F48;
      margin-bottom: 20px;
    }

    .register-container input {
      width: 100%;
      padding: 10px;
      margin: 10px 0;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 14px;
    }

    .register-container button {
      background-color: #422F48;
      color: white;
      border: none;
      padding: 12px 20px;
      border-radius: 8px;
      font-size: 16px;
      cursor: pointer;
      margin-top: 10px;
      width: 100%;
    }

    .register-container button:hover {
      background-color: #341f39;
    }

    footer {
      margin-top: auto;
      padding: 20px;
      text-align: center;
      background-color: #422F48;
      color: white;
      width: 100%;
    }
  </style>
</head>
<body>
    <!-- Logo -->
  <div class="logo">
    <img src="logo.artwave.png" alt="Artwave Logo" />
  </div>

  <!-- Navbar -->
  <nav class="navbar">
    <a href="index.php">Home</a>
    <a href="menu.php">Menu</a>
    <a href="about.html">About</a>
    <a href="contact.php">Contact</a>
    <a href="login.php">Login</a>
    <a href="register.php">Register</a>
    <a href="cart.php">Cart</a>
  </nav>

  <!-- Registration Form -->
  <div class="register-container">
    <h2>Create an Account</h2>
    <form id="registerForm" method="POST" action="register.php">
      <input type="email" name="email" placeholder="Email" required />
      <input type="password" name="password" placeholder="Password" required />
      <input type="password" name="confirmPassword" placeholder="Confirm Password" required />
      <button type="submit">Register</button>
    </form>
  </div>

  <!-- Footer -->
  <footer>
    <p>&copy; 2025 Artwave. All rights reserved. <br> Designed by Saniya Mallick</p>
  </footer>

</body>
</html>
