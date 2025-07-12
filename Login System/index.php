<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>SumanWeb-Login-Portal</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <nav class="navbar">
    <div class="logo">SumanWeb</div>
    <div class="menu" id="menu">
      <!-- Center-aligned navigation links -->
      <ul class="nav-center">
        <li><a href="index.php">Home</a></li>
        <li><a href="#">About</a></li>
        <li><a href="#">Services</a></li>
        <li><a href="#">Contact</a></li>
      </ul>
      <ul class="nav-auth">
        <li><a href="login.php">Login</a></li>
        <li><a href="signup.php">Signup</a></li>
      </ul>
    </div>
    <!-- Mobile menu toggle icon (hamburger menu) -->
    <div class="menu-toggle" id="menu-toggle">
      ☰
    </div>
  </nav>

  <p> <b>Welcome to SumanWeb-Login Portal!</b> Whether you're visiting for the first time or returning to continue your journey, we're glad you're here. To unlock the full experience — including exclusive features, personalized tools, and exciting opportunities — you’ll need to either sign up or log in. Haven’t created an account yet? 👉 <a href="signup.php">Click here to sign up.</a>  Already a member? 🔐 <a href="login.php">Click here to log in.</a>  You’ll find both options conveniently located in the top-left corner of the page. Join our growing community and make the most of what SumanWeb has to offer — your digital journey starts now!
</P>
</body>
</html>
<?php
session_start(); // Start the PHP session to use session variables

// Check if a signup success message is stored in the session
if (isset($_SESSION['signup_success'])) {

    // Display the success message in an alert popup using JavaScript
    echo "<script>alert('" . $_SESSION['signup_success'] . "');</script>";

    // Remove the message from session to prevent it from showing again on refresh
    unset($_SESSION['signup_success']);
}
?>


