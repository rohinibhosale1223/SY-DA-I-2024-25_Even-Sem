<?php
session_start();

// === DB CONNECTION ===
$host = 'localhost';
$dbname = 'parking_db';
$user = 'Yash';
$pass = 'Admin'; // change if your MySQL password is set

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// === HANDLE FORM SUBMISSION ===
$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['action']) && $_POST['action'] == "register") {
        // Register form
        $firstname = trim($_POST['firstname']);
        $lastname = trim($_POST['lastname']);
        $username = trim($_POST['username']);
        $password = $_POST['pass'];

        // Basic validation
        if (empty($firstname) || empty($lastname) || empty($username) || empty($password)) {
            $message = "All fields are required!";
        } elseif (strlen($password) < 6) {
            $message = "Password must be at least 6 characters!";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            try {
                $stmt = $conn->prepare("INSERT INTO users (firstname, lastname, username, pass) VALUES (?, ?, ?, ?)");
                $stmt->execute([$firstname, $lastname, $username, $hashed_password]);
                $message = "Registration successful! Please login.";
            } catch (PDOException $e) {
                if ($e->getCode() == 23000) {
                    $message = "Username already exists.";
                } else {
                    $message = "Registration error: " . $e->getMessage();
                    error_log("Registration error: " . $e->getMessage());
                }
            }
        }
    } elseif (isset($_POST['action']) && $_POST['action'] == "login") {
        // Login form
        $username = trim($_POST['username']);
        $password = $_POST['pass'];

        if (empty($username) || empty($password)) {
            $message = "Both username and password are required!";
        } else {
            try {
                $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
                $stmt->execute([$username]);
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($user && password_verify($password, $user['pass'])) {
                    $_SESSION['user'] = [
                        'username' => $user['username'],
                        'firstname' => $user['firstname'],
                        'lastname' => $user['lastname']
                    ];
                    header("Location: index.php");
                    exit();
                } else {
                    $message = "Invalid username or password.";
                }
            } catch (PDOException $e) {
                $message = "Login error: " . $e->getMessage();
                error_log("Login error: " . $e->getMessage());
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Parking System Login & Register</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: url('https://source.unsplash.com/1600x900/?parking-lot,cars,city') no-repeat center center fixed;
      background-size: cover;
      position: relative;
    }
    body::before {
      content: "";
      position: absolute;
      top: 0; left: 0; width: 100%; height: 100%;
      background: rgba(0, 0, 0, 0.6); z-index: -1;
    }
    .form-container {
      max-width: 400px;
      margin: auto;
      background: rgba(0, 0, 0, 0.8);
      padding: 30px;
      border-radius: 10px;
      color: white;
      box-shadow: 0px 0px 10px rgba(255, 204, 0, 0.7);
    }
    .nav-tabs .nav-link {
      color: white;
      background: black;
      border-radius: 5px;
    }
    .nav-tabs .nav-link.active {
      background: #ffcc00;
      color: black;
    }
    .btn-custom {
      background: #ffcc00;
      color: black;
      font-weight: bold;
      border: none;
    }
    .btn-custom:hover {
      background: #e6b800;
    }
    .alert {
      max-width: 400px;
      margin: 20px auto;
    }
  </style>
</head>
<body>

<div class="container mt-5">
  <?php if ($message): ?>
    <div class="alert alert-info text-center"><?= htmlspecialchars($message) ?></div>
  <?php endif; ?>

  <ul class="nav nav-tabs justify-content-center" role="tablist">
    <li class="nav-item">
      <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#login" type="button">Login</button>
    </li>
    <li class="nav-item">
      <button class="nav-link" data-bs-toggle="tab" data-bs-target="#register" type="button">Register</button>
    </li>
  </ul>

  <div class="tab-content mt-4">
    <!-- Login Tab -->
    <div class="tab-pane fade show active" id="login">
      <div class="form-container">
        <h3 class="text-center mb-3">Parking Login</h3>
        <form method="POST">
          <input type="hidden" name="action" value="login">
          <div class="mb-3">
            <label class="form-label">Username:</label>
            <input type="text" class="form-control" name="username" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Password:</label>
            <input type="password" class="form-control" name="pass" required>
          </div>
          <button type="submit" class="btn btn-custom w-100">Login</button>
        </form>
      </div>
    </div>

    <!-- Register Tab -->
    <div class="tab-pane fade" id="register">
      <div class="form-container">
        <h3 class="text-center mb-3">Parking Register</h3>
        <form method="POST">
          <input type="hidden" name="action" value="register">
          <div class="mb-3">
            <label class="form-label">First Name:</label>
            <input type="text" class="form-control" name="firstname" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Last Name:</label>
            <input type="text" class="form-control" name="lastname" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Username:</label>
            <input type="text" class="form-control" name="username" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Password:</label>
            <input type="password" class="form-control" name="pass" required minlength="6">
          </div>
          <button type="submit" class="btn btn-custom w-100">Register</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>