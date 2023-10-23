<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <!-- Styles -->
    <link rel="stylesheet" href="/assets/css/base.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" type="text/css" href="/assets/css/font-awesome-5.15.1.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="/assets/js/sweetalert2.all.min.js"></script>
    <script src="/assets/js/notifications.js"></script>

    <title>Document</title>

</head>

<body>
<?php require "base.php"?>

    <button type="button" id="test-button-1" class="btn" value="parking-1">Reminder</button>
    <button type="button" id="test-button-2" class="btn" value="parking-2">Blocked for one week</button>
    <button type="button" id="test-button-3" class="btn" value="parking-3">BLocked for 3 days</button>
    <button type="button" id="test-button-4" class="btn" value="parking-4">Violation for one week</button>

    <div class="footer">
        <div class="row container">
            <div class="footer-col">
                <h4>Contact</h4>
                <i class='bx bxs-phone'><span class="icon-text">920002366</span></i><br>
                <i class='bx bxs-envelope'><span class="icon-text">info@kfu.edu.sa</span></i><br>
                <i class='bx bxs-location-plus'><span class="icon-text">Eastern Province - AlAhsa</span></i><br>
            </div>
            <div class="footer-col">
                <h4>About is</h4>
                <a href="">TARKEEN-KFU</a>
            </div>
            <div class="footer-col">
                <h4>Social midea</h4>
                <div class="social-links">
                    <a href="#"><i class='bx bxl-twitter'></i></a>
                    <a href="#"><i class='bx bxl-facebook'></i></a>
                    <a href="#"><i class='bx bxl-instagram-alt'></i></a>
                    <a href="#"><i class='bx bxl-linkedin'></i></a>
                </div>
            </div>
            <div class="footer-col">
                <h4>Let us help you</h4>
                <a href="">Visit Our Help Center</a> <br>
                <a href="">Summary of Services</a><br>
                <a href="">FAQs</a>

            </div>
        </div>
        <section>
            <div class="footer-container">
                <p class="copyright">All Rights Reserved for TARKEEN- KFU © 2023</p>
            </div>
        </section>
    </div>

    <script>

        // setTimeout(function () {
        //     //check that the user is not blocked
        //     //call the backend and check if the user is blocked or not
        //     const blocked_until = getBlockedUntil();
        //     if (blocked_until) {
        //         showBlockedMessage(blocked_until)
        //     }

        // }, 5000);
    </script>
</body>

</html>