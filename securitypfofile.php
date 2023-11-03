<?php include "snippets/base.php" ?>
<?php
require("snippets/force_loggin.php");
if (isset($_POST["edit"])) {
    $carID = $user["cars"][0]["car_id"];
    $upUserquery = "UPDATE `users` SET  `first_name`='$_POST[first_name]',`last_name`='$_POST[last_name]', `email`='$_POST[email]'  WHERE `user_id`='$_POST[user_id]'";
    $upUserResult = $connection->query($upUserquery); // This line will call the database and execute the sql

    $upCarquery = "UPDATE `cars` SET  `car_type`='$_POST[car_type]',`car_plate`='$_POST[car_plate]' WHERE `car_id`='$carID'";
    $upCarResult = $connection->query($upCarquery); // This line will call the database and execute the sql

    if ($upUserResult && $upCarResult) {
        header("Location:home.php");
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Styles -->
    <!-- <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'> -->
    <!-- <link rel="stylesheet" href="./assets/css/font-awesome-5.15.1.min.css"> -->
    <link rel="stylesheet" href="./assets/fontawesome-free-6.4.2-web/css/all.min.css">
    <link rel="stylesheet" href="./assets/css/base.css">
    <link rel="stylesheet" href="./assets/css/profilestyle.css">

    <!-- <link rel="stylesheet" href="./assets/css/style.css"> -->
    <title>profile</title>
    <!-- <script src="https://cdn.tailwindcss.com"></script> -->
</head>

<body class="body">
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha256-pasqAKBDmFT4eHoN2ndd6lN370kFiGUFyTiUHWhU7k8=" crossorigin="anonymous"></script>

<!-- <header>
   <h1>
      Profile Tarkken
   </h1>
</header> -->
<?php include "snippets/layout/header.php" ?>
<main>
    <div class="container-profile">
        <div class="left">
            <form action="#" method="post">
                <div class="img-container">
                    <img src="./assets/img/User-avatar.png" alt="" width="30%" height="30%">
                </div>
                <h3>My Profile</h3>
                <div class="fields">
                    <label for="">
                        <span>ID:</span>
                        <input type="text" name="user_id" value="<?php echo $user['user_id'] ?>" readonly>
                    </label>
                    <label for="">
                        <span>First Name:</span>
                        <input type="text" name="first_name" value="<?php echo $user['first_name'] ?>" readonly>
                    </label>
                    <label for="">
                        <span>Last Name:</span>
                        <input type="text" name="last_name" value="<?php echo $user['last_name'] ?>" readonly>
                    </label>
                    <label for="">
                        <span>Email:</span>
                        <input type="email" name="email" value="<?php echo $user['email'] ?>" readonly>
                    </label>


                </div>
                <class
                ="save-btn">
                <i class="fas fa-pen"></i>

                <div class="save-btn">
                    <button type="submit" name="edit">save</button>
                </div>
            </form>

        </div>

        <div class="right">


            <div class="violation">
                <div class="title">
                    Violations
                </div>
                <ul class="violation-list">
                    <?php
                    // Display violations using data from $user limited to the first 3 records
                    if (isset($user['violations']) && count($user['violations']) > 0) {
                        $displayedViolations = 0;
                        foreach ($user['violations'] as $violation) {
                            if ($displayedViolations < 3) {
                                ?>
                                <li>
                                    <span><?php echo $violation['name'] . '  |   ' . $violation['car_plate']; ?></span>
                                    <span><?php echo date('d F, Y h:i A', strtotime($violation['violation_datetime'])) ?></span>
                                </li>
                                <?php
                                $displayedViolations++;
                            } else {
                                break; // Break the loop after displaying the first 3 records
                            }
                        }
                    }
                    ?>
                </ul>
                <div class="more">
                    <button class="more-btn violation-more-btn">
                        more
                    </button>
                </div>
            </div>
        </div>
    </div>

    <dialog class="dialog dialog-violations">
        <div class="title">
            <span>Violation</span>
            <span class="close vio-close"><i class="fa-solid fa-xmark"></i></span>
        </div>
        <div class="cont-list">
            <ul class="dialog-list">
                <?php
                // Display violations using data from $user limited to the first 3 records
                if (isset($user['violations']) && count($user['violations']) > 0) {
                    foreach ($user['violations'] as $violation) {
                        ?>
                        <li>
                            <span><?php echo $violation['name'] . '  |   ' . $violation['car_plate']; ?></span>
                            <span><?php echo date('d F, Y h:i A', strtotime($violation['violation_datetime'])) ?></span>
                        </li>
                        <?php
                    }
                }
                ?>


            </ul>
        </div>
    </dialog>

</main>
<?php include "snippets/layout/footer.php" ?>
<!-- Javascript -->
<?php include "snippets/layout/scripts.php" ?>
<?php include "snippets/layout/messages.php" ?>
<script src="/assets/js/securtypfoile.js"></script>

</body>

</html>