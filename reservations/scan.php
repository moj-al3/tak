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
    <?php include "../snippets/layout/head.php" ?>
    <title>Reservation Search</title>
    <!-- Include the Instascan library -->
    <!-- <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script> -->
    <script src="https://unpkg.com/html5-qrcode"></script>
    <Style>
        #searchForm {
            width: 500px;
            /* Set the width to 500px */
            text-align: center;
            margin: 0 auto;
            /* Center the form horizontally */
        }
        h2{
            text-align: center;
        }
        label {
            display: block;
            margin-bottom: 10px;
        }

        .reservation-id {
            width: 45%;
            padding: 8px;
            box-sizing: border-box;
            margin-bottom: 15px;
        }

        button {
            padding: 10px 20px;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 50%;
            background-color:  #FF0050;

        }

        button:hover {
            background-color:  #FF0050;
        }
        
    @media (max-width: 600px) {
        /* Adjust styles for smaller screens */
        #searchForm {
            width: 90%; /* Adjusted width for smaller screens */
        }

        .reservation-id,
        button {
            width: 70%; /* Make input and button full-width on smaller screens */
        }
    }
    </Style>
</head>

<body>
    <?php include "../snippets/layout/header.php" ?>

    <h2>Reservation Search</h2>

    <form id="searchForm" action="/reservations/show.php" method="GET">
        <div id="qr-reader"></div>
        <div id="qr-reader-results"></div>
        <label for="reservationId">Enter Reservation ID or Scan QR Code:</label>
        <input type="text" id="reservationId" name="reservation_id" placeholder="Reservation ID" class="reservation-id">
        <button type="submit">Search</button>
    </form>
    <br><br>


    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Get references to form and input elements
            const searchForm = document.getElementById("searchForm");
            const reservationIdInput = document.getElementById("reservationId");

            function onScanSuccess(decodedText, decodedResult) {
                reservationIdInput.value = decodedText;
                searchForm.submit();
            }

            var html5QrcodeScanner = new Html5QrcodeScanner(
                "qr-reader", {
                    fps: 10,
                    qrbox: 250
                });
            html5QrcodeScanner.render(onScanSuccess);
        });
    </script>
    <?php include "../snippets/layout/footer.php" ?>
    <!-- Javascript -->
    <?php include "../snippets/layout/scripts.php" ?>
    <?php include "../snippets/layout/messages.php" ?>
    <script src="/assets/js/header.js"></script>
</body>

</html>