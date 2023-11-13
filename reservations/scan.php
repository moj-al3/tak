<?php include "../snippets/base.php" ?>
<?php
require("../snippets/force_loggin.php");
if ($user["user_type_id"] != "3") {
    die("Access Denied");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation Search</title>
    <!-- Include the Instascan library -->
    <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
</head>

<body>
<h2>Reservation Search</h2>

<form id="searchForm" action="/reservations/show.php" method="GET">
    <label for="reservationId">Enter Reservation ID or Scan QR Code:</label>
    <input type="text" id="reservationId" name="reservation_id" placeholder="Reservation ID">
    <button type="submit">Search</button>
</form>

<!-- Video element for the camera stream -->
<video id="scanner" style="display: none;"></video>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Get references to form and input elements
        const searchForm = document.getElementById("searchForm");
        const reservationIdInput = document.getElementById("reservationId");

        // Create a new Instascan scanner
        const scanner = new Instascan.Scanner({video: document.getElementById('scanner')});

        // Handle QR code scan
        scanner.addListener('scan', function (content) {
            // Set the scanned content to the reservation ID input
            reservationIdInput.value = content;
            // Submit the form
            searchForm.submit();
        });

        // Start the scanner when the page is loaded
        Instascan.Camera.getCameras().then(function (cameras) {
            if (cameras.length > 0) {
                scanner.start(cameras[0]);
            } else {
                console.error('No cameras found.');
            }
        }).catch(function (e) {
            console.error(e);
        });
    });
</script>

</body>

</html>
