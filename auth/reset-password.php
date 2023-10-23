<?php
require_once("start_session.php");
require("../utils/database_connection.php");
require("../utils/validators.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $password = $_POST["password"];
    $token = $_GET["token"] ?? ""; // Get the token from the URL

    // Verify the validity of the reset token
    $query = "SELECT email FROM users WHERE reset_token = ? AND reset_token_expiry > NOW()";
    $stmt = $connection->prepare($query);

    if ($stmt) {
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows == 1) {
            // Token is valid, update the password
            $stmt->bind_result($email);
            $stmt->fetch();

            // Hash the new password (use a secure password hashing method)
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Update the user's password in the database
            $update_query = "UPDATE users SET password = ?, reset_token = NULL, reset_token_expiry = NULL WHERE email = ?";
            $update_stmt = $connection->prepare($update_query);

            if ($update_stmt) {
                $update_stmt->bind_param("ss", $hashed_password, $email);
                $update_stmt->execute();
                $update_stmt->close();

                // Display a success message
                $_SESSION['messages'] = [["text" => "Password reset successfully.\nYou can now log in with your new password.", "type" => "success"]];
                header('Location: /auth/login.php');
                exit();
            } else {
                // Display an error message
                $_SESSION['messages'] = [["text" => "Error while updating the password. Please try again later.", "type" => "error"]];
            }
        } else {
            // Token is invalid or expired
            $_SESSION['messages'] = [["text" => "Invalid or expired reset token. Please request a new password reset.", "type" => "error"]];
        }
        $stmt->close();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <!-- Styles -->
    <link rel="stylesheet" href="/assets/css/base.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="/assets/js/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/assets/css/font-awesome-5.15.1.min.css">
    <link rel="stylesheet" href="/assets/css/landing.css">
    <link rel="stylesheet" href="/assets/css/style.css">
    <title>reset password</title>
</head>

<body>
<div id="content" class="container">
    <form class="reset_form" method="POST">
        <h1>Password Reset</h1>
        <p>Reset your password</p>
        <div class="input-group">
            <label for="new password">New password</label>
            <input type="password" name="password" id="new_pass" required>
        </div>
        <div class="reset">
            <input type="submit" value="Submit">
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


<!-- Javascripts -->
<?php require_once "../utils/messages.php" ?>
</body>

</html>