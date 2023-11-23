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
    <!--    <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>-->
    <script src="https://unpkg.com/html5-qrcode"></script>
</head>

<body>
<h2>Reservation Search</h2>

<form id="searchForm" action="/reservations/show.php" method="GET">
    <div id="qr-reader" style="width:500px"></div>
    <div id="qr-reader-results"></div>
    <label for="reservationId">Enter Reservation ID or Scan QR Code:</label>
    <input type="text" id="reservationId" name="reservation_id" placeholder="Reservation ID">
    <button type="submit">Search</button>
</form>


<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Get references to form and input elements
        const searchForm = document.getElementById("searchForm");
        const reservationIdInput = document.getElementById("reservationId");

        function onScanSuccess(decodedText, decodedResult) {
            reservationIdInput.value = decodedText;
            searchForm.submit();
        }

        var html5QrcodeScanner = new Html5QrcodeScanner(
            "qr-reader", {fps: 10, qrbox: 250});
        html5QrcodeScanner.render(onScanSuccess);
    });


</script>

</body>

</html>
