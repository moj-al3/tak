<?php include "../snippets/base.php" ?>
<?php
// If the user is already logged in, redirect him to the home
if (isset($user)) {
    header('Location: /home.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate and sanitize user inputs
    $data = checkAndCleanPostInputs(["email", "password"]);


//    check if we got the data cleaned or got errors instead
    if (!isset($data["errors"])) {
        // Use prepared statements with placeholders to avoid SQL injection
        $query = "SELECT user_id, password FROM users WHERE email = ?";
        $stmt = $connection->prepare($query);
        $stmt->bind_param("s", $data["email"]);
        $stmt->execute();
        // tell the sql statement to store the result in $user_id and $hashed_password
        $stmt->bind_result($user_id, $hashed_password);
        $stmt->fetch();

        if (password_verify($data["password"], $hashed_password)) {
            // Successfully logged in, set session variables
            $_SESSION['user_id'] = $user_id;
            // Redirect to the user's profile page or any other page
            header('Location: /home.php');
            exit();
        } else {
            $_SESSION['messages'] = [["text" => "Wrong Email or Password", "type" => "error"]];
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "../snippets/layout/head.php" ?>
    <!--  Custom Head Values  -->
    <title>log in</title>
</head>
<body>

<?php include "../snippets/layout/header.php" ?>
<div id="content" class="container">

    <form class="login-form" method="post">
        <h1>Log in</h1>
        <div class="input-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" required>
        </div>
        <div class="input-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" required><br>

            <a href="/auth/forget-password.php"> Forget password ? </a>
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
<?php include "../snippets/layout/footer.php" ?>


<!-- Javascript -->
<?php include "../snippets/layout/scripts.php" ?>
<script src="../assets/js/header.js"></script>


<?php include "../snippets/layout/messages.php" ?>
</body>


</html>