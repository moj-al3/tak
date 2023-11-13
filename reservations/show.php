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
// change this link to get the security to his page
$url = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];


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
                                <li class=" ">
                                    <a href="#" class="block  text-red-500 px-4 py-2 hover:bg-gray-100 ">Cancel Ticket

                                    </a>
                                </li>

                            </ul>

                        </div>

                    </div>
                    <div class="flex w-full justify-between items-center">
                        <div class="flex flex-col items-center">
                            <span class="text-4xl font-bold text-gray-200">PARK</span>
                            <span class="text-parking-text text-sm text-gray-200">Parking Area</span>
                        </div>
                        <div class="flex flex-col flex-grow items-center px-10">
                            <span class="font-bold text-xs text-red-500">Spot 1st-3A</span>
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
                                <span class="text-sm text-red-500">1h 30m</span>
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
                            <span class="font-mono text-gray-200"><?= $car_info["car_plate"] ?></span>
                        </div>
                        <div class="flex flex-col text-gray-200">
                            <span class="text-xs text-parking-text">Vehicle</span>
                            <span class="font-mono text-gray-200"><?= $car_info["car_type"] ?></span>
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

<?php include "../snippets/layout/messages.php" ?>
<script type="text/javascript">
    new QRCode(document.getElementById("qrcode"), {
        text: "<?= $url  ?>",
        width: 128,
        height: 128,
        correctLevel: QRCode.CorrectLevel.H
    });
</script>

</body>

</html>