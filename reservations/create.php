<?php include "../snippets/base.php" ?>
<?php
require("../snippets/force_loggin.php");

function createReservation()
{
    global $connection;
    global $user;

    // Retrieve form data
    $parkingId = $_POST['parking_id'];
    $hours = $_POST['hours'];
    $carId = $_POST['car_id'];


    // Insert reservation data into the database
    $insertReservationSql = "INSERT INTO Reservation (reserver_id, parking_id, car_id, reservation_datetime) VALUES (?, ?, ?, NOW())";
    $insertReservationStmt = $connection->prepare($insertReservationSql);
    $insertReservationStmt->bind_param("iii", $user['user_id'], $parkingId, $carId);

    if ($insertReservationStmt->execute()) {
        $_SESSION['messages'] = [["text" => "Your reservation was created successfully", "type" => "success"]];
        header('Location: /reservations/show.php?reservation_id=' . $insertReservationStmt->insert_id);
        exit();
    } else {
        $_SESSION['messages'] = [["text" => "Failed to create reservation", "type" => "error"]];
        // Handle the error accordingly
    }
    $insertReservationStmt->close();
}

function SwitchReservation()
{
    global $connection;
    global $parkingInfoArray;
    global $occupiedParkingSpots;

    // Retrieve form data
    $previousSpot = $_POST['previous-spot'];
    $newSpot = $_POST['new-spot'];

    // Check if both spots exist in the parkingInfoArray
    if (!isset($parkingInfoArray[$previousSpot]) || !isset($parkingInfoArray[$newSpot])) {
        $_SESSION['messages'] = [["text" => "One or both of the selected spots do not exist", "type" => "error"]];
        return;
    }

    // Check if there is already a reservation in the previous-spot
    if (!in_array($parkingInfoArray[$previousSpot], $occupiedParkingSpots)) {
        $_SESSION['messages'] = [["text" => "There is no reservation in the previous spot", "type" => "error"]];
        return;
    }

    // Check if there is no reservation in the new-spot
    if (in_array($parkingInfoArray[$newSpot], $occupiedParkingSpots)) {
        $_SESSION['messages'] = [["text" => "There is already a reservation in the new spot", "type" => "error"]];
        return;
    }


    // Update the database with the new parking information
    $updateSql = "UPDATE Reservation SET parking_id = ? WHERE parking_id = ? AND DATE(reservation_datetime) = CURDATE()";
    $updateStmt = $connection->prepare($updateSql);
    $updateStmt->bind_param("ii", $parkingInfoArray[$newSpot], $parkingInfoArray[$previousSpot]);

    if ($updateStmt->execute()) {
        $_SESSION['messages'] = [["text" => "Parking spots updated successfully", "type" => "success"]];
        // update the stored data in $user by refreshing the page
        header('Location: /reservations/create.php');
        exit();
    } else {
        $_SESSION['messages'] = [["text" => "Failed to update parking spots", "type" => "error"]];
    }

    // Close the statement
    $updateStmt->close();
}

// Check if the user already has a reservation for today
$checkReservationSql = "SELECT COUNT(*) AS count FROM Reservation WHERE reserver_id = ? AND DATE(reservation_datetime) = CURDATE()";
$checkReservationStmt = $connection->prepare($checkReservationSql);
$checkReservationStmt->bind_param("i", $user['user_id']);
$checkReservationStmt->execute();
$checkReservationResult = $checkReservationStmt->get_result();
$reservationCount = $checkReservationResult->fetch_assoc()['count'];


if ($reservationCount > 0) {
    $_SESSION['messages'] = [["text" => "You already have a reservation for today", "type" => "error"]];
    header('Location: /home.php');  // Redirect to the desired page
    exit();
}

//get all parking information
// Fetch parking spots data from the database
$parkingSpotsSql = "SELECT * FROM ParkingSpots";
$parkingSpotsResult = $connection->query($parkingSpotsSql);

// Create an array to store parking information with parking_id as the value
$parkingInfoArray = [];
while ($row = $parkingSpotsResult->fetch_assoc()) {
    $key = $row['floor_number'] . '-' . $row['zone_number'] . $row['parking_number'];
    $parkingInfoArray[$key] = $row['parking_id'];
}

// Get the current date
$currentDate = date('Y-m-d');
// Retrieve occupied parking spots for today
$occupiedSpotsSql = "SELECT parking_id FROM Reservation WHERE DATE(reservation_datetime) = ? AND exit_datetime IS NULL";
$occupiedStmt = $connection->prepare($occupiedSpotsSql);
$occupiedStmt->bind_param("s", $currentDate);
$occupiedStmt->execute();
$occupiedResult = $occupiedStmt->get_result();

// Create an array to store occupied parking spots
$occupiedParkingSpots = [];
while ($row = $occupiedResult->fetch_assoc()) {
    $occupiedParkingSpots[] = $row['parking_id'];
}

// Close the statement
$occupiedStmt->close();


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    //    make the logic of saving the form
    if ($user["user_type_id"] == "1" || $user["user_type_id"] == "2") {
        createReservation();
    } else {
        SwitchReservation();
    }

}
?>

<!DOCTYPE html>
<html>

<head>
    <?php include "../snippets/layout/head.php" ?>
    <link rel="stylesheet" href="../assets/css/booking.css">
    <style>
        .time-reservation.selected {
            background-color: #FF0050;
        }

        .spot.available:hover {
            color: white;
        }

        .spot {
            text-align: center;
            margin: 6px;
            color: gray;
            -webkit-user-select: none; /* Safari */
            -ms-user-select: none; /* IE 10 and IE 11 */
            user-select: none; /* Standard syntax */
        }
    </style>
    <title>Create Reservation</title>
</head>

<body>
<?php include "../snippets/layout/header.php" ?>
<div id="content" class="container">
    <div class="spot-container">
        <label>Pick a flour:</label>
        <select id="floor">
            <option value="floor1">floor1</option>
            <option value="floor2">floor2</option>
            <option value="floor3">floor3</option>
        </select>
        <?php if ($user["user_type_id"] == "1" || $user["user_type_id"] == "2"): ?>
            <label>Choose car :</label>
            <select id="car">
                <?php
                foreach ($user["cars"] as $car) {
                    echo '<option value="' . $car['car_id'] . '">' . $car['car_type'] . ' - ' . $car['car_plate'] . '</option>';
                }
                ?>

            </select>
        <?php endif; ?>
    </div>
    <ul class="showcase">
        <li>
            <div class="spot"></div>
            <small>Available</small>
        </li>
        <li>
            <div class="spot selected"></div>
            <small>Reserved</small>
        </li>
    </ul>


    <div class="row-container" id="floorContainer">
        <?php
        $floors = [1, 2, 3];

        foreach ($floors as $floor) {
            $floorClass = ($floor === 1) ? '' : 'hide';
            echo '<div id="floor' . $floor . '" class="floor ' . $floorClass . '">';
            $rows = ['A', 'B', 'C', 'D', 'E', 'F'];

            foreach ($rows as $row) {
                echo '<div class="row">';
                for ($i = 1; $i <= 9; $i++) {
                    $spot = $row . $i;
                    $key = $floor . '-' . $spot;

                    // Check if the key exists in the array before accessing it
                    $spotClass = isset($parkingInfoArray[$key]) && in_array($parkingInfoArray[$key], $occupiedParkingSpots)
                        ? 'spot occupied'
                        : 'spot available';

                    echo '<div class="' . $spotClass . '" data-parking-id="' . ($parkingInfoArray[$key] ?? "") . '">' . $spot . '</div>';
                }
                echo '</div>';
            }

            echo '</div>';
        }
        ?>
    </div>

    <?php if ($user["user_type_id"] == "2"): ?>
        <div class="time-selection">
            <button class="time-reservation" data-hours="1">1 hour</button>
            <button class="time-reservation" data-hours="2">2 hours</button>
            <button class="time-reservation" data-hours="3">3 hours</button>
        </div>
    <?php endif ?>

    <?php if ($user["user_type_id"] == "1" || $user["user_type_id"] == "2"): ?>


        <div class="reserve-btn">
            <button class="rserve" type="button" id="reserve">Reserve</button>
        </div>
    <?php else: ?>
        <div class="switch-btn">
            <button id="switchButton">Switch</button>
        </div>
    <?php endif; ?>

</div>

<?php include "../snippets/layout/footer.php" ?>
<?php include "../snippets/layout/scripts.php" ?>
<?php include "../snippets/layout/messages.php" ?>
<script>
    const timeRequired = <?= $user["user_type_id"] == "2" ? 'true' : 'false' ?>;
    const reserve = document.getElementById('reserve');
    const timeButtons = document.querySelectorAll('.time-reservation');
    const rowContainer = document.querySelector('.row-container');
    const floorSelector = document.getElementById('floor');
    const carSelector = document.getElementById('car');
    const spots = document.querySelectorAll('.spot.available');
    let selectedSpot = null;
    let selectedTime = null;


    timeButtons.forEach(button => {
        button.addEventListener('click', (e) => {
            // Remove the "selected" class from all buttons
            timeButtons.forEach(b => {
                b.classList.remove('selected');
            });
            // Add the "selected" class to the clicked button
            button.classList.add('selected');
            selectedTime = button;
        });
    });


    // floor selection
    floorSelector.addEventListener('change', function () {
        var floors = rowContainer.querySelectorAll('.floor');
        floors.forEach(function (floor) {
            floor.classList.add('hide');
        });
        document.getElementById(floorSelector.value).classList.remove('hide');
        if (selectedSpot) {
            selectedSpot.classList.remove('selected');
            selectedSpot = null;
        }
    });

    // spot click event
    rowContainer.addEventListener('click', (e) => {
        if (e.target.classList.contains('spot') && e.target.classList.contains('available')) {
            if (selectedSpot) {
                selectedSpot.classList.remove('selected');
            }
            e.target.classList.add('selected');
            selectedSpot = e.target;
        }
    });
    if (reserve != undefined)
        reserve.addEventListener("click", function () {
            if (selectedSpot == undefined) {
                Swal.fire({
                    text: "Please Select A Spot",
                    icon: "error",
                    showConfirmButton: false,
                });
                return;
            }
            if (selectedTime == undefined && timeRequired) {
                Swal.fire({
                    text: "Please Select A Time Period",
                    icon: "error",
                    showConfirmButton: false,
                });
                return;
            }
            var parkingId = selectedSpot.getAttribute("data-parking-id");
            var hours = selectedTime === undefined ? selectedTime?.getAttribute("data-hours") : 0;
            var car = carSelector.value;
            submitForm({"parking_id": parkingId, "hours": hours, "car_id": car})
        })
</script>
<?php if ($user["user_type_id"] == "3"): ?>
    <script>
        document.getElementById('switchButton').addEventListener('click', () => {
            // Show the first SweetAlert with input fields and a checkbox
            Swal.fire({
                title: 'Switch Spot',
                html: `
                  <input type="text" id="previous-spot" class="" placeholder="Previous Spot e.g 1-A1">
                  <input type="text" id="new-spot" placeholder="New Spot e.g 1-A1">
                  </label><input type="checkbox" id="apply-violation"/> Apply Violation for this reservation</label>
            `,

                showCancelButton: true,
                confirmButtonText: 'switch',
                showLoaderOnConfirm: true,
                preConfirm: () => {

                    const previousSpot = document.getElementById('previous-spot').value;
                    const newSpot = document.getElementById('new-spot').value;
                    const applyViolation = document.getElementById('apply-violation').checked;


                    if (!previousSpot || !newSpot) {
                        Swal.showValidationMessage('Both fields are required');
                        return false;
                    }

                    if (!applyViolation) {
                        Swal.showValidationMessage('Please confirm applying the violation');
                        return false;
                    }
                    submitForm({"previous-spot": previousSpot, "new-spot": newSpot});

                },
            });
        });
    </script>
<?php endif; ?>
<script src="../assets/js/header.js"></script>

</body>

</html>