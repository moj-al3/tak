<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <!-- Styles -->
    <link rel="stylesheet" href="/assets/css/base.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" type="text/css" href="/assets/css/font-awesome-5.15.1.min.css">
    <link rel="stylesheet" href="/assets/css/landing.css">
    <link rel="stylesheet" href="/assets/css/style.css">
    <title>reset password</title>
</head>

<body>
    <div id="content" class="container">
        <!-- TODO: remove the action link and reset the method to post after adding php (backend) -->
        <form action="/auth/login.php" class="reset_form" method="get">
            <h1>Password Reset</h1>
            <p>Reset your password</p>
            <div class="input-group">
                <label for="new password">New password</label>
                <input type="password" name="new password" id="new_pass" required>
            </div>
            <div class="input-group">
                <label for="con password">Confirm password</label>
                <input type="password" name="confirm password" id="confirm_pass" required>
            </div> <br>
            <div class="reset">
                <input type="submit" value="Submit">
            </div>
        </form>
    </div>
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


    <!-- Javascripts -->

</body>

</html>