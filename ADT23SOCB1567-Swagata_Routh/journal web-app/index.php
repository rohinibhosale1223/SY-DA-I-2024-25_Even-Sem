<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>MyJournal - Home</title>
  <link rel="stylesheet" href="css/journal-index.css">
</head>
<body>

  <header>
    <h1>MyJournal</h1>
    <nav>
      <a href="index.php">Home</a>
      <a href="about.html">About</a>
      <a href="contact-us.html">Contact Us</a>
      <a href="logout.php">Logout</a>
    </nav>
  </header>

  <section class="hero">
    <h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
    <p>Your Daily Space to Reflect</p>
    <a href="create-entry.php" class="cta-button">Start Journaling</a>
  </section>

  <section class="section">
    <img src="images/images.png" alt="MyJournal Banner" />
    <div class="cards">
      <div class="card">
        <h3>Track Your Mood</h3>
        <p>Log your emotions with mood tags and visual cues to understand your mental journey.</p>
      </div>
      <div class="card">
        <h3>Search Your Thoughts</h3>
        <p>Use filters and keywords to easily find past entries by date or content.</p>
      </div>
      <div class="card">
        <h3>Rich Text Editor</h3>
        <p>Format your journal with bold, italics, bullet lists and more.</p>
      </div>
    </div>
  </section>

  <footer>
    <p>© 2025 MyJournal. All rights reserved.</p>
  </footer>

</body>
</html>
