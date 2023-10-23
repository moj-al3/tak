<?php
require_once("auth/start_session.php");
require("utils/database_connection.php");
require("auth/force_loggin.php");

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <!-- Styles -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" type="text/css" href="/assets/css/font-awesome-5.15.1.min.css">
    <link rel="stylesheet" href="/assets/css/base.css">
    <link rel="stylesheet" href="/assets/css/style.css">

    <title>profile</title>
</head>

<body>
<?php require "base.php"?>
        <a href="/auth/logout.php" style="color: black;"> log out</a>

    </div>
    </div>
    <div id="content" class="container">
    <?php echo "<h1>Welcome " . $_SESSION['first_name'] . "</h1>"; ?>
    </div>

</body>

</html>