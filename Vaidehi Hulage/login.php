<?php
session_start();
include 'db_connect.php';

$email = $password = "";
$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize inputs
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $password = trim($_POST["password"]);

    // Validate inputs
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please enter a valid email address.";
    }
    if (empty($password)) {
        $errors[] = "Please enter your password.";
    }

    if (empty($errors)) {
        // Prepare and execute SQL query
        $stmt = $conn->prepare("SELECT id, name, email, password FROM users WHERE email = ?");
        if ($stmt) {
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            // Verify user credentials
            if ($result && $result->num_rows === 1) {
                $user = $result->fetch_assoc();

                if (password_verify($password, $user['password'])) {
                    // Successful login
                    $_SESSION["user_id"] = $user['id'];
                    $_SESSION["user_name"] = $user['name'];
                    $_SESSION["user_email"] = $user['email'];

                    echo "<p style='color:green;'>Welcome, <strong>" . htmlspecialchars($user['name'], ENT_QUOTES, 'UTF-8') . "</strong>! Redirecting to the shop...</p>";
                    header("refresh:2;url=shop.php"); // Redirect after 2 seconds
                    exit();
                } else {
                    $errors[] = "Incorrect password.";
                }
            } else {
                $errors[] = "No account found with that email.";
            }

            $stmt->close();
        } else {
            $errors[] = "Database query failed. Please try again later.";
        }
    }

    $conn->close();
}

// Display errors
if (!empty($errors)) {
    foreach ($errors as $error) {
        echo "<p style='color:red;'>" . htmlspecialchars($error, ENT_QUOTES, 'UTF-8') . "</p>";
    }
}
?>
