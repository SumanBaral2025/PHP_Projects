<?php
// Start the session to manage user login state
session_start();

// Check if the user is not logged in
// If not, redirect them to the login page
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit(); // Prevent further script execution
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Set the dynamic title with the logged-in username -->
  <title>SumanWeb - <?php echo htmlspecialchars($_SESSION['username']); ?></title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <nav class="navbar">
    <div class="logo">SumanWeb</div>
      <div class="menu" id="menu">
        <ul class="nav-center">
          <li><a href="index.php">Home</a></li>
          <li><a href="#">About</a></li>
          <li><a href="#">Services</a></li>
          <li><a href="#">Contact</a></li>
        </ul>
        <ul class="nav-auth">
          <li><a href="logout.php">Logout</a></li>
        </ul>
      </div>
      <!-- Menu toggle button for small screens -->
    <div class="menu-toggle" id="menu-toggle">☰</div>
  </nav>

  <!-- Welcome heading displaying the logged-in user's name -->
  <h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?> 👋</h2>

  <?php
  // If a signup success message is stored in the session
  // Show it using a JavaScript alert and then remove it from session
  if (isset($_SESSION['signup_success'])) {
      echo "<script>alert('" . $_SESSION['signup_success'] . "');</script>";
      unset($_SESSION['signup_success']); // Clean up after showing
  }
  ?>
</body>
</html>

