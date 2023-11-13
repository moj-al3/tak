<?php include "snippets/base.php" ?>
<?php
require("snippets/force_loggin.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //    make the logic of saving the form
    $result = saveProfile($connection, $user);
    if ($result === true) {
        $_SESSION['messages'] = [["text" => "Your user information updated successfully", "type" => "success"]];
        // update the stored data in $user by refreshing the page
        header('Location: /home.php');
        exit();
    } else {
        $_SESSION['messages'] = [["text" => $result, "type" => "error"]];
    }

}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "snippets/layout/head.php" ?>
    <link rel="stylesheet" href="/assets/css/profilestyle.css">
    <style>
        #actions {
            margin: 1px;
            float: right;
        }

        .link {
            color: black;
        }
    </style>
    <title>Home</title>
</head>

<body class="body">
<?php include "snippets/layout/header.php" ?>
<main>
    <div class="container-profile">
        <div class="left">
            <form action="" method="POST" id="user-form">
                <div id="actions">
                    <i class="bx bxs-edit bx-md" id="edit"></i>
                    <i class="bx bxs-save bx-md hide" id="save"></i>
                </div>
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
                        <input class="editable" type="text" name="first_name" value="<?= $user['first_name'] ?>"
                               readonly>
                    </label>
                    <label for="">
                        <span>Last Name:</span>
                        <input class="editable" type="text" name="last_name" value="<?= $user['last_name'] ?>" readonly>
                    </label>
                    <label for="">
                        <span>Email:</span>
                        <input class="editable" type="email" name="email" value="<?= $user['email'] ?>" readonly>
                    </label>
                    <?php if ($user["user_type_id"] == "1" || $user["user_type_id"] == "2"): ?>
                        <label for="">
                            <span>Car Type:</span>
                            <input class="editable" type="text" name="car_type1"
                                   value="<?= $user["cars"][0]['car_type'] ?? '' ?>" readonly>
                                   <span>Car Plate:</span>
                            <input class="editable" type="text" name="car_plate1"
                                   value="<?= $user["cars"][0]['car_plate'] ?? '' ?>" readonly>
                                   <p><span id="delete">delete</span></p>
                        </label>

                        <label for="">
                        <span>Do you want to</span>
                        <p><span id="new car" class ="new-car">Add new car</span></p>
                    </label>
                        
                    <?php endif; ?>

                </div>

            </form>
        </div>

        <div class="right">
            <?php if ($user["user_type_id"] == "1" || $user["user_type_id"] == "2"): ?>
                <div class="violation">
                    <div class="title">
                        <span>Reservations</span>
                        <i class="bx bx-plus-circle bx-sm" style="float: right"
                           onclick="window.location.href = '/reservations/create.php'">

                        </i>
                    </div>
                    <ul class="reservations-list">
                        <?php
                        // Display reservations using data from $user
                        if (count($user['reservations']) > 0) {
                            $displayedReservations = 0;
                            foreach ($user['reservations'] as $reservation) {
                                if ($displayedReservations < 3) {
                                    ?>
                                    <a href="/reservations/show.php?reservation_id=<?= $reservation['reservation_id'] ?>"
                                       class="link">
                                        <li>
                                            <span><?= $reservation['parking_number'] ?></span>
                                            <span><?= date('d F, Y h:i A', strtotime($reservation['reservation_datetime'])) ?></span>
                                        </li>
                                    </a>
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
            <?php endif; ?>
            <div class="violation">
                <div class="title">
                    <span>Violations</span>
                    <?php if ($user["user_type_id"] == "3"): ?>
                        <i class="bx bx-plus-circle bx-sm" style="float: right"
                           onclick="window.location.href = '/violations/create.php'">
                        </i>
                    <?php endif; ?>
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
                if (isset($user['violations']) && count($user['violations']) > 0) {
                    foreach ($user['violations'] as $violation) {
                        ?>
                        <li>
                            <span><?php echo $violation['name'] . '  |   ' . $violation['car_plate']; ?></span>
                            <span><?php echo date('d F, Y h:i A', strtotime($violation['violation_datetime'])) ?></span>
                            <span><?php echo $violation["note"] ?></span>
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
                        <a href="/reservations/show.php?reservation_id=<?= $reservation['reservation_id'] ?>"
                           class="link">
                            <li>
                                <span><?= $reservation['parking_number'] ?></span>
                                <span><?= date('d F, Y h:i A', strtotime($reservation['reservation_datetime'])) ?></span>
                            </li>
                        </a>
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

<script>
    $(function () {
        // trigger form editing when the edit icon is clicked
        $("#edit").on("click", function () {
            $("#edit").addClass("hide");
            $("#save").removeClass("hide");
            $(".editable").removeAttr('readonly');
        });

        $("#save").on("click", async function () {
            var response = await Swal.fire({
                title: "Confirmation",
                text: "Are you sure you want to save the changes?",
                confirmButtonText: "Yes",
                showCancelButton: true,
                cancelButtonText: "Cancel",
                cancelButtonColor: '#ff0050',

            });
            if (response.isConfirmed) {
                $("#user-form").submit();
            }
        });
    });
</script>
<script src="/assets/js/header.js"></script>

</body>

</html>