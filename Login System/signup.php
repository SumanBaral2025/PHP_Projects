<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SumanWeb-Signup</title>
    <link rel="stylesheet" href="signupstyle.css">
</head>
<body>
    <div class="signup-container">
        <h1>Create a new account</h1>

        <!-- Signup form using POST method that submits to signup.php -->
        <form class="signup-form" id="signupForm" method="post" action="signup.php">
            <div class="name-fields">
                <input type="text" name="name" maxlength="20" placeholder="Enter your name" required>
            </div>
            <input type="text" name="email_phone" maxlength="50" placeholder="Mobile number or email address" required>
            <input type="password" name="newpassword" id="password" placeholder="New password" required>
            <input type="password" name="conpassword" id="confirmPassword" placeholder="Confirm password" required>

            <!-- Terms and privacy agreement notice -->
            <p class="terms">
                By signing up, you agree to our <a href="#">Terms</a>, <a href="#">Privacy Policy</a>, and <a
                    href="#">Cookies Policy</a>.
            </p>
            <button type="submit" class="signup-btn">Sign Up</button>
        </form>
        <p id="error-message" class="error-message"></p>
    </div>
</body>
</html>
<?php
include 'part/_dbconnect.php';// Include the database connection script
session_start();// Start the session to store messages and login state
if ($_SERVER['REQUEST_METHOD'] == 'POST') { // Check if the form was submitted via POST
    
    // Collect data from the form
    $name = $_POST['name'];
    $email_phone = $_POST['email_phone'];
    $newpassword = $_POST['newpassword'];
    $conpassword = $_POST['conpassword'];
    
    // ✅ Check if passwords match
    if ($newpassword !== $conpassword) {
        $_SESSION['signup_error'] = "❌ Passwords do not match!";
        header("Location: signup.php");
        exit();
    }
     // ✅ Hash the password correctly
     $hash = password_hash($newpassword, PASSWORD_DEFAULT);


    // ✅ Check if username already exists in the database
    $existSql = "SELECT * FROM `signup` WHERE `name` = '$name'";
    $result = mysqli_query($conn, $existSql);

    // Check if database connection fails
    if (!$conn) {
        $_SESSION['signup_error'] = "❌ Connection failed!";
        header("Location: signup.php");
        exit();
    }
    // If username already exists, show error
    if (mysqli_num_rows($result) > 0) {
        $_SESSION['signup_error'] = "❌ Username already taken! Please choose a different one.";
        header("Location: signup.php");
        exit();
    }
    // ✅ Insert user data into the signup table
    $sql = "INSERT INTO `signup` (`name`, `email_phone`, `newpassword`,  `date`) 
            VALUES ('$name', '$email_phone', '$hash', current_timestamp())";
    $result = mysqli_query($conn, $sql);

    // Check if the insertion was successful
    if ($result) {
        // Success message and redirect to index/login
        $_SESSION['signup_success'] = "✅ Congratulations! Your account has been created successfully. Now you can log in and start your journey with SumanWeb.";
        header("Location: index.php");
        exit();
    } else {
        // If insert fails
        $_SESSION['signup_error'] = "❌ Submission failed! Please try again.";
        header("Location: signup.php");
        exit();
    }
}
?>
<?php
// If a signup error exists in session, show it using JavaScript alert
if (isset($_SESSION['signup_error'])) {
    $errorMessage = json_encode($_SESSION['signup_error']); // Convert to JS-safe string
    echo "<script>alert($errorMessage);</script>";
    unset($_SESSION['signup_error']); // Clear it after showing
}
?>


