<?php
require_once("start_session.php");
require("../utils/database_connection.php");
require("../utils/validators.php");


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];

    // Validate the email
    if (filter_var($email, FILTER_VALIDATE_EMAIL) && isEmailAlreadyUsed($connection, $email)) {
        // Generate a random token for password reset (you should use a secure method)
        $token = bin2hex(random_bytes(32));

        // Store the token in the users table along with the user's email
        $query = "UPDATE users SET reset_token = ?, reset_token_expiry = DATE_ADD(NOW(), INTERVAL 1 HOUR) WHERE email = ?";
        $stmt = $connection->prepare($query);

        if ($stmt) {
            $stmt->bind_param("ss", $token, $email);
            $stmt->execute();
            $stmt->close();

            // Send an email to the user with a link to reset the password
            $reset_link = "https://yourwebsite.com/reset_password.php?token=" . $token;

            // Compose the email message
            $subject = "Password Reset";
            $message = "To reset your password, click the following link:\n\n$reset_link";

            // send the email
//            mail($email, $subject, $message);

            // Display a success message to the user
            $_SESSION['messages'] = [["text" => "We have sent a password recover instructions to your email..\nDid not receive the email? Check your spm filter", "type" => "success"]];
            header('Location: /auth/login.php');
            exit();
        } else {
            // Display an error message
            $_SESSION['messages'] = [["text" => "Error while updating the reset token. Please try again later.", "type" => "error"]];
        }
    } else {
        // Display an error message for an invalid email
        $_SESSION['messages'] = [["text" => "Invalid email address.", "type" => "error"]];
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
    <title>forget password</title>
</head>

<body>
<div id="content" class="container">
    <form class="fp_form" method="POST">
        <h1>Forget Password</h1>
        <p>Please enter your email address</p>
        <div class="input-group">
            <label for="email">Email*</label>
            <input type="email" name="email" id="email" required>
        </div>
        <br>
        <div class="Forget_password">
            <input type="submit" value="submit">
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