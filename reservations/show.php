<?php include "../snippets/base.php" ?>
<?php
require("../snippets/force_loggin.php");


if (!isset($_GET['reservation_id'])) {
    die("No reservation ID provided in the URL.");
}

// Get the reservation_id from the GET parameter
$reservation_id = $_GET['reservation_id'];

// Prepare the SQL statement with a placeholder for the parameters
$sql = "SELECT * FROM Reservation WHERE reservation_id = ?";
// Prepare the statement
$stmt = $connection->prepare($sql);
// Bind the parameters
$stmt->bind_param("i", $reservation_id);

// Execute the statement
$stmt->execute();

// Get the result
$result = $stmt->get_result();

// Check if the query was successful
if ($result == false || $result->num_rows == 0) {
    die("No reservation found for the provided ID");
}
// Check if there is a matching reservation
// Fetch the reservation data
$reservation = $result->fetch_assoc();

// Check if the query was successful
if ($user["user_type_id"] != "3" && $reservation["reserver_id"] != $user["user_id"]) {
    die("No reservation found for the provided ID");
}
// Free the result set
$result->free();
// Close the statement
$stmt->close();


// Retrieve parking information using the parking_id from the reservation
$parking_id = $reservation['parking_id'];

// Prepare SQL statement to get parking details
$sqlParking = "SELECT * FROM ParkingSpots WHERE parking_id = ?";

// Prepare the statement for parking details
$stmtParking = $connection->prepare($sqlParking);

// Bind the parameter
$stmtParking->bind_param("i", $parking_id);

// Execute the statement to get parking details
$stmtParking->execute();

// Get the result for parking details
$resultParking = $stmtParking->get_result();

// Check if the query was successful
if ($resultParking == false || $resultParking->num_rows == 0) {
    die("No parking spot found for the reservation");
}

// Fetch the parking information
$parking_info = $resultParking->fetch_assoc();

// Retrieve car information using the car_id from the reservation
$car_id = $reservation['car_id'];

// Prepare SQL statement to get Car details
$sqlCar = "SELECT * FROM Cars WHERE car_id = ?";

// Prepare the statement for parking details
$stmtCar = $connection->prepare($sqlCar);

// Bind the parameter
$stmtCar->bind_param("i", $car_id);

// Execute the statement to get car details
$stmtCar->execute();

// Get the result for car details
$resultCar = $stmtCar->get_result();

// Check if the query was successful
if ($resultCar == false || $resultCar->num_rows == 0) {
    die("No car found for the reservation");
}

// Fetch the car information
$car_info = $resultCar->fetch_assoc();


// Free the result set and close the statement for car details
$resultCar->free();
$stmtCar->close();
$needFeedback = false;
// Check if the ticket is closed'
if ($reservation['enter_datetime'] !== null && $reservation['exit_datetime'] !== null && $user["user_type_id"] != 3) {
    // Check if there is no feedback for the reservation
    $feedbackQuery = "SELECT * FROM FeedBacks WHERE reservation_id = ?";
    $feedbackStmt = $connection->prepare($feedbackQuery);
    $feedbackStmt->bind_param("i", $reservation['reservation_id']);
    $feedbackStmt->execute();
    $feedbackResult = $feedbackStmt->get_result();
    $needFeedback = boolval($feedbackResult->num_rows === 0);
    // Close the feedback statement
    $feedbackStmt->close();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    switch ($_POST["action"] ?? "") {
        case "checkIn":
            checkIn($connection, $user);
            break;
        case "checkOut":
            checkOut($connection, $user);
            break;
        case "cancelReservation":
            cancelReservation($connection, $user);
            break;
        case "submitRating":
            rateReservation($connection, $user);
            break;
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.js"></script>
    <script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>
    <script src="/assets/js/sweetalert2.all.min.js"></script>

    <style>
        body {
            overflow-x: hidden;
            background-image: linear-gradient(to top, #a7a6cb 0%, #8989ba 52%, #8989ba 100%);
            background-position: center !important;
            background-repeat: no-repeat !important;
            background-size: contain !important;

        }
    </style>
</head>

<body>

<div class="containerd">
    <main class="w-screen h-screen flex flex-col">

        <section class="w-full flex-grow bg-parking-bg flex flex-cold items-center justify-center  p-4">

            <div class="flex w-full max-w-3xl text-parking-text h-64">

                <div class="h-full bg-gray-800 flex items-center justify-center px-8 rounded-l-3xl flex-col">
                    <div id="qrcode"></div>
                    <p class="text-gray-200">Scan to check in </p>
                    <p class="text-gray-200">ID: <?= $reservation['reservation_id'] ?></p>
                </div>
                <div class="relative h-full flex flex-col items-center border-dashed justify-between border-2 bg-gray-800 border-parking-text">
                    <div class="absolute rounded-full w-8 h-8 bg-white -top-5"></div>
                    <div class="absolute rounded-full w-8 h-8 bg-white -bottom-5"></div>
                </div>
                <div class="h-full py-8 px-10 bg-gray-800 flex-grow rounded-r-3xl flex flex-col text-gray-200">
                    <div class="flex flex-end justify-end">

                        <?php if ($reservation['enter_datetime'] == null || $reservation['exit_datetime'] == null): ?>
                            <button id="dropdownMenuIconButton" data-dropdown-toggle="dropdownDots"
                                    class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-200 bg-gray-800 rounded-lg hover:bg-gray-600 focus:ring-4 focus:outline-none  focus:ring-gray-50  "
                                    type="button">
                                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                     fill="currentColor" viewBox="0 0 4 15">
                                    <path d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z"/>
                                </svg>
                            </button>

                            <div id="dropdownDots"
                                 class="z-10 hidden bg-gray-400 divide-y divide-gray-100 rounded-lg shadow w-44 ">
                                <ul class="py-2 text-sm text-gray-900 " aria-labelledby="dropdownMenuIconButton">
                                    <?php if ($user["user_type_id"] == "3" && $reservation['enter_datetime'] == null): ?>
                                        <li><a href="#" class="block px-4 py-2 hover:bg-gray-100 "
                                               onclick="submitAction('checkIn')">Check in</a></li>
                                    <?php elseif ($user["user_type_id"] == "3" && $reservation['exit_datetime'] == null): ?>
                                        <li><a href="#" class="block px-4 py-2 hover:bg-gray-100 "
                                               onclick="submitAction('checkOut')">Check out</a></li>
                                    <?php endif; ?>
                                    <?php if ($reservation['enter_datetime'] == null && $reservation['exit_datetime'] == null): ?>
                                        <li><a href="#" class="block px-4 py-2 hover:bg-gray-100"
                                               onclick="submitAction('cancelReservation')">Cancel Ticket</a></li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        <?php endif; ?>


                    </div>
                    <div class="flex w-full justify-between items-center">
                        <div class="flex flex-col items-center">
                            <span class="text-4xl font-bold text-gray-200">PARK</span>
                            <span class="text-parking-text text-sm text-gray-200">Parking Area</span>
                        </div>
                        <div class="flex flex-col flex-grow items-center px-10">
                            <span class="font-bold text-xs text-gray-200">Spot <?= $parking_info['floor_number'] . 'st-' . $parking_info['zone_number'] . $parking_info["parking_number"] ?></span>
                            <div class="w-full flex items-center mt-2">
                                <div class="w-3 h-3 rounded-full border-2 border-parking-text"></div>
                                <div class="flex-grow border-t-2 border-zinc-400 border-dotted h-px"></div>
                                <!-- <div class="flex-grow border-t-2 border-parking-line border-dotted h-px"></div> -->
                                <img src="/assets/img/car-2.png" class="w-6 h-6 mx-2" alt="">
                                <div class="flex-grow border-t-2 border-zinc-400 border-dotted h-px"></div>
                                <!-- <div class="flex-grow border-t-2 border-parking-line border-dotted h-px"></div> -->
                                <div class="w-3 h-3 rounded-full border-2 border-parking-text"></div>
                            </div>
                            <div class="flex items-center px-3 rounded-full bg-parking-time h-8 mt-2">
                                <span class="text-sm text-gray-200">1h 30m</span>
                            </div>
                        </div>
                        <div class="flex flex-col items-center text-gray-200">
                            <span class="text-4xl font-bold text-gray-200">EXIT</span>
                            <span class="text-parking-text text-sm">Exit Gate</span>
                        </div>
                    </div>
                    <div class="flex w-full mt-auto justify-between">
                        <div class="flex flex-col">
                            <span class="text-xs text-parking-text text-gray-200">Date</span>
                            <span class="font-mono text-gray-200"><?= date('d/m/Y', strtotime($reservation['reservation_datetime'])) ?></span>
                        </div>
                        <div class="flex flex-col text-gray-200">
                            <span class="text-xs text-parking-text">Car Number</span>
                            <span class="font-mono"><?= $car_info["car_plate"] ?></span>
                        </div>
                        <div class="flex flex-col text-gray-200">
                            <span class="text-xs text-parking-text">Vehicle</span>
                            <span class="font-mono"><?= $car_info["car_type"] ?></span>
                        </div>
                        <div class="flex flex-col text-gray-200">
                            <span class="text-xs text-parking-text">Floor/Spot</span>
                            <span class="font-mono"><?= $parking_info['floor_number'] . '/' . $parking_info['zone_number'] . $parking_info["parking_number"] ?></span>

                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>

</div>
<?php include "../snippets/layout/scripts.php" ?>
<?php include "../snippets/layout/messages.php" ?>
<script type="text/javascript">
    new QRCode(document.getElementById("qrcode"), {
        text: "<?= $reservation_id  ?>",
        width: 128,
        height: 128,
        correctLevel: QRCode.CorrectLevel.H
    });

    function submitAction(action) {
        submitForm({"action": action})
    }

    var selectedRating = 0;
    var selectionColor = "text-[#ff0000]";

    function updateStar(rating) {
        if (selectedRating != 0) {
            $("#star" + selectedRating + "-icon").removeClass(selectionColor);
        }
        selectedRating = rating;
        $("#star" + selectedRating + "-icon").addClass(selectionColor);
        $('input[name="rating"][value="' + selectedRating + '"]').prop('checked', true);


    }

    if (<?= $needFeedback ? "true" : "false"?>) {
        Swal.fire({
            title: "Share Your Sparkle ✨",
            allowOutsideClick: false,
            confirmButtonText: "Submit",
            preConfirm: () => {


                if (selectedRating == 0) {
                    Swal.showValidationMessage('Please Select an option is required');
                    return false;
                }
                submitForm({"action": "submitRating", "rating": selectedRating});

            },
            html: `
            <form class="space-y-4">
                <!-- Rating Selection -->
            <div class="flex items-center space-x-4 justify-center">
                <!-- <label for="rating" class="text-lg">Rating:</label> -->
            <ul class="my-1 flex list-none gap-2 p-0" data-te-rating-init data-te-dynamic="true"
            data-te-active="bg-current rounded-[50%] !fill-black">
            <li>
            <input type="radio" name="rating" id="star1" value="1" class="hidden"/>
            <label for="star1" class="cursor-pointer" onclick="updateStar(1)">
            <span id="star1-icon" class="text-[#673ab7] [&>svg]:h-10 [&>svg]:w-10 [&>svg]:fill-current"
            data-te-rating-icon-ref>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                <!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
            <path d="M256 48a208 208 0 1 1 0 416 208 208 0 1 1 0-416zm0 464A256 256 0 1 0 256 0a256 256 0 1 0 0 512zm72.4-118.5c9.7-9 10.2-24.2 1.2-33.9C315.3 344.3 290.6 328 256 328s-59.3 16.3-73.5 31.6c-9 9.7-8.5 24.9 1.2 33.9s24.9 8.5 33.9-1.2c7.4-7.9 20-16.4 38.5-16.4s31.1 8.5 38.5 16.4c9 9.7 24.2 10.2 33.9 1.2zM176.4 272c17.7 0 32-14.3 32-32c0-1.5-.1-3-.3-4.4l10.9 3.6c8.4 2.8 17.4-1.7 20.2-10.1s-1.7-17.4-10.1-20.2l-96-32c-8.4-2.8-17.4 1.7-20.2 10.1s1.7 17.4 10.1 20.2l30.7 10.2c-5.8 5.8-9.3 13.8-9.3 22.6c0 17.7 14.3 32 32 32zm192-32c0-8.9-3.6-17-9.5-22.8l30.2-10.1c8.4-2.8 12.9-11.9 10.1-20.2s-11.9-12.9-20.2-10.1l-96 32c-8.4 2.8-12.9 11.9-10.1 20.2s11.9 12.9 20.2 10.1l11.7-3.9c-.2 1.5-.3 3.1-.3 4.7c0 17.7 14.3 32 32 32s32-14.3 32-32z"/>
            </svg>
            </span>
            </li>
            <li>
            <input type="radio" name="rating" id="star2" value="2" class="hidden"/>
            <label for="star2" class="cursor-pointer" onclick="updateStar(2)">
            <span id="star2-icon" class="text-[#3f51b5] [&>svg]:h-10 [&>svg]:w-10 [&>svg]:fill-current"
            data-te-rating-icon-ref>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                <!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
            <path d="M464 256A208 208 0 1 0 48 256a208 208 0 1 0 416 0zM0 256a256 256 0 1 1 512 0A256 256 0 1 1 0 256zM174.6 384.1c-4.5 12.5-18.2 18.9-30.7 14.4s-18.9-18.2-14.4-30.7C146.9 319.4 198.9 288 256 288s109.1 31.4 126.6 79.9c4.5 12.5-2 26.2-14.4 30.7s-26.2-2-30.7-14.4C328.2 358.5 297.2 336 256 336s-72.2 22.5-81.4 48.1zM144.4 208a32 32 0 1 1 64 0 32 32 0 1 1 -64 0zm192-32a32 32 0 1 1 0 64 32 32 0 1 1 0-64z"/>
            </svg>
            </span>
            </li>
            <li>
            <input type="radio" name="rating" id="star3" value="3" class="hidden"/>
            <label for="star3" class="cursor-pointer" onclick="updateStar(3)">
            <span id="star3-icon" class="text-[#2196f3] [&>svg]:h-10 [&>svg]:w-10 [&>svg]:fill-current"
            data-te-rating-icon-ref>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                <!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
            <path d="M464 256A208 208 0 1 1 48 256a208 208 0 1 1 416 0zM256 0a256 256 0 1 0 0 512A256 256 0 1 0 256 0zM176.4 240a32 32 0 1 0 0-64 32 32 0 1 0 0 64zm192-32a32 32 0 1 0 -64 0 32 32 0 1 0 64 0zM184 328c-13.3 0-24 10.7-24 24s10.7 24 24 24H328c13.3 0 24-10.7 24-24s-10.7-24-24-24H184z"/>
            </svg>
            </span>
            </li>
            <li>
            <input type="radio" name="rating" id="star4" value="4" class="hidden"/>
            <label for="star4" class="cursor-pointer" onclick="updateStar(4)">
            <span id="star4-icon" class="text-[#03a9f4] [&>svg]:h-10 [&>svg]:w-10 [&>svg]:fill-current"
            data-te-rating-icon-ref>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                <!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
            <path d="M464 256A208 208 0 1 0 48 256a208 208 0 1 0 416 0zM0 256a256 256 0 1 1 512 0A256 256 0 1 1 0 256zm177.6 62.1C192.8 334.5 218.8 352 256 352s63.2-17.5 78.4-33.9c9-9.7 24.2-10.4 33.9-1.4s10.4 24.2 1.4 33.9c-22 23.8-60 49.4-113.6 49.4s-91.7-25.5-113.6-49.4c-9-9.7-8.4-24.9 1.4-33.9s24.9-8.4 33.9 1.4zM144.4 208a32 32 0 1 1 64 0 32 32 0 1 1 -64 0zm192-32a32 32 0 1 1 0 64 32 32 0 1 1 0-64z"/>
            </svg>
            </span>
            </li>
            <li>
            <input type="radio" name="rating" id="star5" value="5" class="hidden"/>
            <label for="star5" class="cursor-pointer" onclick="updateStar(5)">
            <span id="star5-icon" class="text-[#00bcd4] [&>svg]:h-10 [&>svg]:w-10 [&>svg]:fill-current"
            data-te-rating-icon-ref>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
            <path d="M256 48a208 208 0 1 1 0 416 208 208 0 1 1 0-416zm0 464A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM183.2 132.6c-1.3-2.8-4.1-4.6-7.2-4.6s-5.9 1.8-7.2 4.6l-16.6 34.7-38.1 5c-3.1 .4-5.6 2.5-6.6 5.5s-.1 6.2 2.1 8.3l27.9 26.5-7 37.8c-.6 3 .7 6.1 3.2 7.9s5.8 2 8.5 .6L176 240.5l33.8 18.3c2.7 1.5 6 1.3 8.5-.6s3.7-4.9 3.2-7.9l-7-37.8L242.4 186c2.2-2.1 3.1-5.3 2.1-8.3s-3.5-5.1-6.6-5.5l-38.1-5-16.6-34.7zm160 0c-1.3-2.8-4.1-4.6-7.2-4.6s-5.9 1.8-7.2 4.6l-16.6 34.7-38.1 5c-3.1 .4-5.6 2.5-6.6 5.5s-.1 6.2 2.1 8.3l27.9 26.5-7 37.8c-.6 3 .7 6.1 3.2 7.9s5.8 2 8.5 .6L336 240.5l33.8 18.3c2.7 1.5 6 1.3 8.5-.6s3.7-4.9 3.2-7.9l-7-37.8L402.4 186c2.2-2.1 3.1-5.3 2.1-8.3s-3.5-5.1-6.6-5.5l-38.1-5-16.6-34.7zm6.3 175.8c-28.9 6.8-60.5 10.5-93.6 10.5s-64.7-3.7-93.6-10.5c-18.7-4.4-35.9 12-25.5 28.1c24.6 38.1 68.7 63.5 119.1 63.5s94.5-25.4 119.1-63.5c10.4-16.1-6.8-32.5-25.5-28.1z"/>
            </svg>
            </span>
            </li>
            </ul>
            </div>
            </form>`

            })
            }

</script>

</body>

</html>

