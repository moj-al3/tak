<?php include "../snippets/base.php" ?>
<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $password = $_POST["password"];
    $token = $_GET["token"] ?? ""; // Get the token from the URL

    // Verify the validity of the reset token
    $query = "SELECT email FROM Users WHERE reset_token = ? AND reset_token_expiry > NOW()";
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
            $update_query = "UPDATE Users SET password = ?, reset_token = NULL, reset_token_expiry = NULL WHERE email = ?";
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
    <?php include "../snippets/layout/head.php" ?>
    <!--  Custom Head Values  -->
    <title>reset password</title>
</head>

<body>
<?php include "../snippets/layout/header.php" ?>
<div id="content" class="container">
    <form class="reset_form" method="POST" onsubmit="return validatePassword()">
        <h1>Password Reset</h1>
        <p>Reset your password</p>
        <div class="input-group">
            <label for="new password">New password</label>
            <input type="password" name="password" id="password" required>
            <p class="error-message" id="password_err" hidden></p>
        </div>
        <div class="reset">
            <input type="submit" value="Submit">
        </div>
    </form>
</div>
<?php include "../snippets/layout/footer.php" ?>


<!-- Javascript -->
<?php include "../snippets/layout/scripts.php" ?>
<script src="../assets/js/header.js"></script>

<script>
    function validatePassword() {

        var password = document.getElementById("password").value;
        var passwordErr = document.getElementById("password_err");
        passwordErr.innerHTML = "";
        if (password.length < 7) {
            passwordErr.innerHTML = "password must be longer than 7 characters";
            passwordErr.hidden = false;
            return false; // Prevent form submission
        }
        return true; // Allow form submission
    }
</script>


<?php include "../snippets/layout/messages.php" ?>
</body>

</html>