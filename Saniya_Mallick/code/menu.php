<?php
session_start();
// Optional: Redirect to login if user is not logged in
// Uncomment below if login is required to access the menu
// if (!isset($_SESSION["email"])) {
//   header("Location: login.php");
//   exit();
// }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Artwave</title>
  <link rel="stylesheet" href="style.css"/>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">
</head>
<body>

  <!-- Logo -->
  <div class="logo">
    <img src="logo.artwave.png" alt="Artwave Logo" />
  </div>

  <!-- Navigation Bar -->
  <nav class="navbar">
    <a href="index.php">Home</a>
    <a href="menu.php">Menu</a>
    <a href="about.php">About</a>
    <a href="contact.php">Contact</a>
    <a href="register.php">Register</a>
    <a href="login.php">Login</a>
    <a href="cart.php">Cart</a>
  </nav>

  <!-- Overlay -->
  <div class="overlay"></div>

  <!-- Menu Content -->
  <section class="menu-content">
    <h2 class="site-name">Artwave</h2>
    <p>Select a Mood to Explore Music and Art</p>

    <!-- Mood Buttons -->
    <div class="mood-buttons">
      <div class="mood-button-container">
        <a href="relax.php"><button class="mood-button">Relax</button></a>
      </div>
      <div class="mood-button-container">
        <a href="motivation.php"><button class="mood-button">Motivation</button></a>
      </div>
      <div class="mood-button-container">
        <a href="study.php"><button class="mood-button">Study</button></a>
      </div>
      <div class="mood-button-container">
        <a href="workout.php"><button class="mood-button">Workout</button></a>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer>
    <p>&copy; 2025 Artwave. All rights reserved.</p>
  </footer>

<script src="menu.js"></script>

</body>
</html>
