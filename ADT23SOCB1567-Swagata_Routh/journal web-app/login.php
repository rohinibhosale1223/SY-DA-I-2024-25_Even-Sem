<?php
session_start();
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $pass = $_POST['pass'];

    $conn = new mysqli("localhost", "root", "", "journal_db");

    if ($conn->connect_error) {
        die("Database connection failed!");
    }

    $sql = "SELECT * FROM usr_tbl WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Use password_verify() if you store hashed passwords
        if ($row['password'] === $pass) {
            $_SESSION['username'] = $username;
            header("Location: index.php");
            exit();
        } else {
            $error = "Incorrect password.";
        }
    } else {
        // Optional: redirect to register instead
        $error = "User not found. <a href='register.html'>Register here</a>";
    }

    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <link rel="stylesheet" href="css/journal-home.css" />
  <title>Login Form</title>
</head>
<body>
  <form action="login.php" method="post">
    <h2>Login Form</h2>

    <?php if (!empty($error)): ?>
      <div class="msg" style="color:red;"><?php echo $error; ?></div>
    <?php endif; ?>

    <label for="username">User Name</label>
    <input type="text" class="box" placeholder="Enter User name" id="username" name="username" required />

    <label for="pass">Password</label>
    <input type="password" class="box" placeholder="Enter Password" id="pass" name="pass" required />
    
    <button id="show-pass" type="button" onclick="togglePassword()">Show Password</button>
    <input type="submit" id="submit-btn" value="Login" />
  </form>

  <script>
    function togglePassword() {
      const pass = document.getElementById('pass');
      const btn = document.getElementById('show-pass');
      if (pass.type === "password") {
        pass.type = "text";
        btn.textContent = "Hide Password";
      } else {
        pass.type = "password";
        btn.textContent = "Show Password";
      }
    }
  </script>
</body>
</html>
