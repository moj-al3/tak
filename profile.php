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
        header("Location:profile.php");
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Styles -->
    <link rel="stylesheet" href="/assets/css/font-awesome-5.15.1.min.css">
    <link rel="stylesheet" href="/assets/css/base.css">
    <link rel="stylesheet" href="/assets/css/profilestyle.css">
    <title>profile</title>
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
            <form action="" method="POST">
                <div class="img-container">
                    <img src="/assets/img/User-avatar.png" alt="" width="30%" height="30%">
                </div>
                <h3>My Profile</h3>
                <div class="fields">
                    <label for="">
                        <span>ID:</span>
                        <input type="text" name="user_id" value="<?= $user['user_id'] ?>" readonly>
                    </label>
                    <label for="">
                        <span>First Name:</span>
                        <input type="text" name="first_name" value="<?= $user['first_name'] ?>" required>
                    </label>
                    <label for="">
                        <span>Last Name:</span>
                        <input type="text" name="last_name" value="<?= $user['last_name'] ?>" required>
                    </label>
                    <label for="">
                        <span>Email:</span>
                        <input type="email" name="email" value="<?= $user['email'] ?>" required>
                    </label>
                    <label for="">
                        <span>Car Type:</span>
                        <input type="text" name="car_type" value="<?= $user["cars"][0]['car_type'] ?>" required>
                    </label>
                    <label for="">
                        <span>Car Plate:</span>
                        <input type="text" name="car_plate" value="<?= $user["cars"][0]['car_plate'] ?>" required>
                    </label>

                </div>
                <div class="save-btn">
                    <button type="submit" name="edit">Edit</button>
                </div>
            </form>
        </div>

        <div class="right">
            <div class="reservations">
                <div class="title">
                    Reservations
                </div>
                <ul class="reservations-list">
                    <?php
                    // Display reservations using data from $user
                    if (count($user['reservations']) > 0) {
                        $displayedReservations = 0;
                        foreach ($user['reservations'] as $reservation) {
                            if ($displayedReservations < 3) {
                                ?>
                                <li>
                                    <span><?php echo $reservation['parking_number']; ?></span>
                                    <span><?php echo date('d F, Y h:i A', strtotime($reservation['reservation_datetime'])) ?></span>
                                </li>
                                <?php
                                $displayedReservations++;
                            } else {
                                break; // Break the loop after displaying the first 3 records
                            }
                        }
                    }
                    ?>

                </ul>
                <div class="more">
                    <button class="more-btn reservations-more-btn">
                        more
                    </button>
                </div>
            </div>
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

    <dialog class="dialog dialog-reservations">
        <div class="title">
            <span>Reservations</span>
            <span class="close re-close"><i class="fa-solid fa-xmark"></i></span>
        </div>
        <div class="cont-list">
            <ul class="dialog-list">
                <?php
                // Display reservations using data from $user
                if (count($user['reservations']) > 0) {
                    foreach ($user['reservations'] as $reservation) {
                        ?>
                        <li>
                            <span><?php echo $reservation['parking_number']; ?></span>
                            <span><?php echo date('d F, Y h:i A', strtotime($reservation['reservation_datetime'])) ?></span>
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
<script src="/assets/js/profile-tarkken.js"></script>

</body>

</html>