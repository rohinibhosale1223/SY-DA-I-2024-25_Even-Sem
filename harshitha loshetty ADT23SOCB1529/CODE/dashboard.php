<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: index.html");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Weather Dashboard</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <h2>Welcome, <?php echo htmlspecialchars($_SESSION["username"]); ?>!</h2>
  <a href="logout.php">Logout</a>
  <div>
    <input type="text" id="city" placeholder="Enter city">
    <button onclick="getWeather()">Get Weather</button>
  </div>
  <div id="weatherResult"></div>
  <script src="weather.js"></script>
</body>
</html>
