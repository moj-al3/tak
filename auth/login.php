<?php
require_once("start_session.php");
require("../utils/database_connection.php");
require("../utils/validators.php");

$error = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate and sanitize user inputs
    $data = checkAndCleanPostInputs(["email", "password"]);

    if (!isset($data["errors"])) {
        // Use prepared statements with placeholders to avoid SQL injection
        $query = "SELECT user_id, first_name, password FROM users WHERE email = ?";
        $stmt = $connection->prepare($query);
        $stmt->bind_param("s", $data["email"]);
        $stmt->execute();
        $stmt->bind_result($user_id, $first_name, $hashed_password);
        $stmt->fetch();

        if (password_verify($data["password"], $hashed_password)) {
            // Successfully logged in, set session variables
            $_SESSION['user_id'] = $user_id;
            // Redirect to the user's profile page or any other page
            header('Location: /profile.php');
            exit();
        } else {
            $error = "Wrong Email or Password";
        }
    }
}

// If the user is already logged in, redirect to the home
if (isset($_SESSION['user_id'])) {
    header('Location: /profile.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <!-- Styles -->
    <link rel="stylesheet" href="/assets/css/base.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" type="text/css" href="/assets/css/font-awesome-5.15.1.min.css">
    <link rel="stylesheet" href="/assets/css/landing.css">
    <link rel="stylesheet" href="/assets/css/style.css">


    <title>log in</title>
</head>
<body>
<div id="content" class="container">
    <form class="login-form" method="post">
        <!-- php -->
        <?php
        if (isset($error)) {
            echo "<h2>$error</h2>";
        }
        ?>
        <h1>Log in</h1>
        <div class="input-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" required>
        </div>
        <div class="input-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" required><br>

            <a href="/forget-password.php"> Forget password ? </a>
        </div>
        <div class="login">
            <input type="submit" value="log in">
            <div class="flex-container">
                <p>Don't have an account?</p>
                <button type="button" onclick="window.location.href = '/auth/signup.php'">sign up</button>
            </div>
        </div>
    </form>
</div>

<div class="footer">
    <div class="row container">
        <div class="footer-col">
            <h4>Contact</h4>
            <i class='bx bxs-phone'><span class="icon-text">920002366</span></i><br>
            <i class='bx bxs-envelope'><span class="icon-text">info@kfu.edu.sa</span></i><br>
            <i class='bx bxs-location-plus'><span class="icon-text">Eastern Province - AlAhsa</span></i><br>
        </div>
        <div class="footer-col">
            <h4>About is</h4>
            <a href="">TARKEEN-KFU</a>
        </div>
        <div class="footer-col">
            <h4>Social midea</h4>
            <div class="social-links">
                <a href="#"><i class='bx bxl-twitter'></i></a>
                <a href="#"><i class='bx bxl-facebook'></i></a>
                <a href="#"><i class='bx bxl-instagram-alt'></i></a>
                <a href="#"><i class='bx bxl-linkedin'></i></a>
            </div>
        </div>
        <div class="footer-col">
            <h4>Let us help you</h4>
            <a href="">Visit Our Help Center</a> <br>
            <a href="">Summary of Services</a><br>
            <a href="">FAQs</a>

        </div>
    </div>
    <section>
        <div class="footer-container">
            <p class="copyright">All Rights Reserved for TARKEEN- KFU © 2023</p>
        </div>
    </section>
</div>


</body>


</html>