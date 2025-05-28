<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Register Form</title>
  <link rel="stylesheet" href="css/journal-home.css"/>
</head>
<body>
  <form id="register-form" method="POST" action="">
    <h2>Register</h2>

    <label for="new-username">User Name</label>
    <input type="text" class="box" placeholder="Enter User name" id="new-username" name="username" required />

    <label for="new-pass">Password</label>
    <input type="password" class="box" placeholder="Enter Password" id="new-pass" name="password" required />

    <label for="email">Email</label>
    <input type="email" class="box" placeholder="Enter Email" id="email" name="email" required />

    <button id="toggle-pass" type="button">Show Password</button>
    <input type="submit" id="register-btn" value="Register" disabled />

    <div class="msg">
      <?php
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
          $username = $_POST['username'];
          $pass = $_POST['password'];
          $email = $_POST['email'];

          $servername = "localhost";
          $db_username = "root"; // update if needed
          $db_password = "";     // update if needed
          $dbname = "journal_db";

          $conn = new mysqli($servername, $db_username, $db_password, $dbname);

          if ($conn->connect_error) {
              echo "<span style='color:red;'>Connection failed: " . $conn->connect_error . "</span>";
          } else {
              // Use prepared statements
              $stmt = $conn->prepare("INSERT INTO usr_tbl (username, password, email) VALUES (?, ?, ?)");
              $stmt->bind_param("sss", $username, $pass, $email);

              if ($stmt->execute()) {
                  echo "<span style='color:green;'>Registration successful! Redirecting to login...</span>";
                  echo "<script>setTimeout(() => window.location.href = 'login.php', 2000);</script>";
              } else {
                  echo "<span style='color:red;'>Username might already exist or error occurred.</span>";
              }

              $stmt->close();
              $conn->close();
          }
      }
      ?>
    </div>
  </form>

  <script>
    const newUsername = document.getElementById('new-username');
    const newPass = document.getElementById('new-pass');
    const registerBtn = document.getElementById('register-btn');
    const togglePassBtn = document.getElementById('toggle-pass');

    let usernameValid = false;
    let passwordValid = false;

    newUsername.addEventListener('input', () => {
        usernameValid = newUsername.value.length > 5;
        newUsername.style.borderColor = usernameValid ? 'green' : 'red';
        toggleRegister();
    });

    newPass.addEventListener('input', () => {
        passwordValid = /^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{6,16}$/.test(newPass.value);
        newPass.style.borderColor = passwordValid ? 'green' : 'red';
        toggleRegister();
    });

    togglePassBtn.addEventListener('click', () => {
        if (newPass.type === 'password') {
            newPass.type = 'text';
            togglePassBtn.textContent = 'Hide Password';
        } else {
            newPass.type = 'password';
            togglePassBtn.textContent = 'Show Password';
        }
    });

    function toggleRegister() {
        registerBtn.disabled = !(usernameValid && passwordValid);
    }
  </script>
</body>
</html>
