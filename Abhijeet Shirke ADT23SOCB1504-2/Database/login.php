<?php
session_start();

// Database credentials
$host = "localhost";
$user = "abhijeet";
$password = "abhijeet61";
$dbname = "tourism_db";

// Create connection
$conn = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Check if form submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = trim($_POST['email']);
  $password = $_POST['password'];

  // Validate input
  if (empty($email) || empty($password)) {
    echo "All fields are required!";
    exit();
  }

  // Prepare SQL statement
  $stmt = $conn->prepare("SELECT id, name, password FROM users WHERE email = ?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $stmt->store_result();

  // Check if user exists
  if ($stmt->num_rows > 0) {
    $stmt->bind_result($id, $name, $hashed_password);
    $stmt->fetch();

    // Verify password
    if (password_verify($password, $hashed_password)) {
      // Successful login
      $_SESSION['user_id'] = $id;
      $_SESSION['user_name'] = $name;

      // Redirect to welcome/home page
      header("Location: welcome.php");
      exit();
    } else {
      echo "❌ Incorrect password!";
    }
  } else {
    echo "❌ No user found with that email!";
  }

  $stmt->close();
}

$conn->close();
?>
