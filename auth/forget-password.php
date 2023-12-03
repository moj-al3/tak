<?php include "../snippets/base.php" ?>
<?php include "../snippets/emailSender.php" ?>
<?php


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];

    // Validate the email
    if (filter_var($email, FILTER_VALIDATE_EMAIL) && isEmailAlreadyUsed($connection, $email)) {
        // Generate a random token for password reset
        $token = bin2hex(random_bytes(32));
        $currentDatetime = date('Y-m-d H:i:s');

        // Store the token in the users table along with the user's email
        $query = "UPDATE Users SET reset_token = ?, reset_token_expiry = DATE_ADD(?, INTERVAL 1 HOUR) WHERE email = ?";
        $stmt = $connection->prepare($query);

        if ($stmt) {
            $stmt->bind_param("sss", $token, $currentDatetime, $email);
            $stmt->execute();
            $stmt->close();

            sendPasswordResetEmail($email, $token);

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
    <?php include "../snippets/layout/head.php" ?>
    <!--  Custom Head Values  -->
    <title>forget password</title>
</head>

<body>
<?php include "../snippets/layout/header.php" ?>
<div id="content" class="container">
    <form class="fp_form" method="POST">
        <h1 style="text-align: center; 
        font-size:30px">Forget Password</h1>
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
<?php include "../snippets/layout/footer.php" ?>


<!-- Javascript -->
<?php include "../snippets/layout/scripts.php" ?>
<script src="../assets/js/header.js"></script>


<?php include "../snippets/layout/messages.php" ?>
</body>

</html>