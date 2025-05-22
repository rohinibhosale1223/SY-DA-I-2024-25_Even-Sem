<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
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

  <!-- Video Background -->
  <video autoplay muted loop playsinline class="background-video">
    <source src="videobg.mp4" type="video/mp4" />
    Your browser does not support the video tag.
  </video>

  <!-- Overlay -->
  <div class="overlay"></div>

  <!-- Hero Content -->
  <section class="hero-content">
    <h2 class="site-name">Artwave</h2>
    <h1>Where Every Mood Finds Its Music and Muse</h1>
    <p>Enter the Realm of Mood-Driven Music & Art</p>
    
    <!-- Get Started Button -->
    <a href="menu.php" class="get-started-btn">Get Started</a>
  </section>

  <!-- Logout Button -->
  <div class="logout-container">
    <a href="logout.php" class="logout-btn">Logout</a>
  </div>

  <script src="script.js"></script>
</body>
</html>
