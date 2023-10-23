<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <!-- Styles -->
    <link rel="stylesheet" href="/assets/css/base.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" type="text/css" href="/assets/css/font-awesome-5.15.1.min.css">
    <link rel="stylesheet" href="/assets/css/style.css">
    <title>Login</title>
</head>

<body>
    <div id="content" class="container">
        <form class="login-form" method="post">
            <?php
            session_start();
            $HOST = "127.0.0.1";
            $USERNAME = "root";
            $PASSWORD = "";
            $DATABASE_NAME = "Tarkeen";

            //  Create connection
            $connection = mysqli_connect($HOST, $USERNAME, $PASSWORD, $DATABASE_NAME);

            // Check connection
            if (!$connection) {
                die("Connection failed: " . mysqli_connect_error());
            }
            function validate($data)
            {
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
                return $data;
            }

            $error = null;

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if (isset($_POST['email']) && isset($_POST['password'])) {
                    $email = validate($_POST['email']);
                    $password = validate($_POST['password']);

                    if (!empty($email) && !empty($password)) {
                        // Perform database query securely using prepared statements
                        $query = "SELECT * FROM users WHERE email=? AND password=?";
                        $stmt = $connection->prepare($query);
                        $stmt->bind_param("ss", $email, $password);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        if ($result->num_rows == 1) {
                            $row = $result->fetch_assoc();
                            $_SESSION['email'] = $row['email'];
                            $_SESSION['first_name'] = $row['first_name'];
                            header('Location: /home.php');
                            exit();
                        } else {
                            $error = "Wrong email or password";
                        }
                        $stmt->close();
                    } else {
                        $error = "Both email and password are required";
                    }
                }
            }

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
                <input type="password" name="password" id="password" required>
                <br>
                <a href="/Archive/forget-password.php">Forget password?</a>
            </div>
            <div class="login">
                <input type="submit" value="Log in">
                <div class="flex-container">
                    <p>Don't have an account?</p>
                    <button type="button" onclick="window.location.href = '/Archive/registration.php'">Sign up</button>
                </div>
            </div>
        </form>
    </div>

    <div class="footer">
        <!-- Your footer content here -->
    </div>
</body>

</html>