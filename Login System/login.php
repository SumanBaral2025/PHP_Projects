<?php
session_start(); // Start a session to track user login state and error messages

include 'part/_dbconnect.php'; // Include database connection file

// Check if the login form was submitted using POST method
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Step 1: Get the data entered in the form
    $name = $_POST['name'];                    // Username input
    $email_phone = $_POST['email_phone'];      // Email or phone input
    $newpassword = $_POST['newpassword'];      // Password input

    // Step 2: Write SQL query to find user with matching name and email/phone
    $sql = "SELECT * FROM signup WHERE name='$name' AND email_phone='$email_phone'";
    $result = mysqli_query($conn, $sql); // Execute the query
    $num = mysqli_num_rows($result);     // Get how many users matched (should be 1)

    // Step 3: If exactly 1 matching user found
    if ($num == 1) {
        while($row = mysqli_fetch_assoc($result)) {// Fetch the user row from the result

            // Step 4: Verify if entered password matches the hashed password from database
            if (password_verify($newpassword, $row['newpassword'])) {
                // ✅ Password correct — user is logged in

                // Set session variables to store user login state
                $_SESSION['signup_success'] = "✅ You are logged in.";
                $_SESSION['username'] = $name;
                $_SESSION['loggedin'] = true;

                // Redirect to the welcome page
                header("Location: welcome.php");
                exit();
            } else {
                // ❌ Password is incorrect
                $_SESSION['signup_error'] = "❌ Invalid Password! Please check your credentials.";
                header("Location: login.php");
                exit();
            }
        }
    } else {
        // ❌ No matching user found (wrong name or email/phone)
        $_SESSION['signup_error'] = "❌ Login failed! Please check your credentials.";
        header("Location: login.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SumanWeb - Login</title>
    <link rel="stylesheet" href="signupstyle.css">
</head>
<body>
    <div class="signup-container">
        <h1>Login to your account</h1>

        <!-- Login form that sends data via POST method to login.php -->
        <form class="signup-form" id="signupForm" method="post" action="login.php">

            <div class="name-fields">
                <input type="text" name="name" placeholder="Enter your name" required>
            </div>
            <input type="text" name="email_phone" placeholder="Mobile number or email address" required>
            <input type="password" name="newpassword" id="password" placeholder="Enter your password" required>

            <button type="submit" class="signup-btn">Login Now</button>
        </form>
    </div>

    <?php
    // If a login error message is set in the session, display it in an alert
    if (isset($_SESSION['signup_error'])) {
        echo "<script>alert('" . $_SESSION['signup_error'] . "');</script>";
        unset($_SESSION['signup_error']); // Unset the error after displaying to avoid repeated alerts
    }
    ?>
</body>
</html>

