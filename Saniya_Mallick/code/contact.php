<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Contact - Artwave</title>
  <link rel="stylesheet" href="style.css" />
  <style>
    
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #fff;
      color: #422F48;
      margin: 0;
      padding: 0;
    }
.navbar {
      background-color: #422F48;
      padding: 18px;
      width: 100%;
      text-align: center;
    }

    .navbar a {
      color: white;
      margin: 0 4px;
      text-decoration: none;
      font-weight: 520;
    }


    .contact-container {
      max-width: 600px;
      margin: 50px auto;
      padding: 30px;
      border-radius: 20px;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.05);
      background-color: #fdfdfd;
    }

    h1 {
      text-align: center;
      margin-bottom: 30px;
      color: #422F48;
    }

    form {
      display: flex;
      flex-direction: column;
    }

    label {
      margin-bottom: 5px;
      font-weight: 500;
    }

    input, textarea {
      padding: 12px;
      margin-bottom: 20px;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 1rem;
    }

    textarea {
      resize: vertical;
      min-height: 120px;
    }

    button {
      background-color: #422F48;
      color: #fff;
      padding: 12px;
      font-size: 1rem;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    button:hover {
      background-color: #311f36;
    }

    .footer {
      text-align: center;
      margin-top: 50px;
      font-size: 0.9rem;
      color: #888;
      padding-bottom: 20px;
    }
  </style>
</head>
<body>

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


  <div class="contact-container">
    <h1>Contact Us</h1>
    <form onsubmit="submitContact(event)">
      <label for="name">Your Name</label>
      <input type="text" id="name" name="name" required>

      <label for="email">Your Email</label>
      <input type="email" id="email" name="email" required>

      <label for="message">Your Message</label>
      <textarea id="message" name="message" required></textarea>

      <button type="submit">Send Message</button>
    </form>
  </div>

  <div class="footer">
    &copy; 2025 Artwave. All rights reserved.
  </div>

  <script>
    function submitContact(event) {
      event.preventDefault();
      alert("Thanks for reaching out! We'll get back to you soon.");
      document.querySelector("form").reset();
    }
  </script>
<!-- Logo -->
<div class="logo">
  <a href="index.html">
    <img src="logo.artwave.png" alt="Artwave Logo" />
  </a>
</div>

</body>
</html>
