<?php
require("../utils/database_connection.php");
?>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="/assets/js/script.js" defer></script>
    <script src="/assets/js/validation.js" defer></script>

    <title>Registration</title>
</head>

<body>
<div id="content" class="container">
    <form class="form" id="regestration_form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <h1>Create Account</h1>
        <!--Progress bar--->
        <div class="progressbar">
            <div class="progress" id="progress">

            </div>
            <div class="progress-step progress-step-active">
            </div>
            <div class="progress-step"></div>
            <div class="progress-step"></div>
            <div class="progress-step"></div>
        </div>
        <!-- radio group  -->

        <div class="radio-container">
            <p>I am a :</p>
            <div class="radio-group">
                <input type="radio" id="visitor" name="user_type_id" value="2">
                <label for="visitor">Visitor</label>
                <input type="radio" id="kfu_member" name="user_type_id" value="1">
                <label for="kfu_member">KFU member</label>
            </div>
        </div>
        <!--- steps -->

        <!-- step 1 -->
        <div class="form-step form-step-active">
            <div class="input-group">
                <label for="first name">First name</label>
                <input type="text" name="first_name" id="first_name" required>
                <p class="error-message" id="first_name_err" hidden></p>
            </div>
            <div class="input-group">
                <label for="last name">Last name</label>
                <input type="text" name="last_name" id="last_name" required>
                <p class="error-message" id="last_name_err" hidden></p>
            </div>
            <div class="">
                <a href="#" class="btn btn-next width-50 ml-auto" id="btn-next1">Next</a>
            </div>
        </div>
        <!-- step 2 -->
        <div class="form-step ">
            <div class="input-group">
                <label for="national_id" id="national_id_label">National ID </label>
                <input type="text" name="user_id" id="national_id" required>
                <p class="error-message" id="national_id_err" hidden></p>
            </div>
            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" required>
                <p class="error-message" id="email_err" hidden></p>

            </div>
            <div class="btn-group">
                <a href="#" class="btn btn-prev ">Previous</a>
                <a href="#" class="btn btn-next ">Next</a>
            </div>
        </div>
        <!-- step 3 -->
        <div class="form-step ">
            <div class="input-group">
                <label for="carPlate">Car plate </label>
                <input type="text" name="car_plate" id="car_plate" required>
                <p class="error-message" id="car_plate_err" hidden></p>
            </div>
            <div class="input-group">
                <label for="carType">Car type</label>
                <input type="text" name="car_type" id="car_type" required>
                <p class="error-message" id="car_type_err" hidden></p>

            </div>
            <div class="btn-group">
                <a href="#" class="btn btn-prev ">Previous</a>
                <a href="#" class="btn btn-next ">Next</a>
            </div>
        </div>
        <!-- step 4 -->
        <div class="form-step ">
            <div class="input-group">
                <label for="password">Password </label>
                <input type="password" name="password" id="password" required>
                <p class="error-message" id="password1_err" hidden></p>

            </div>
            <div class="input-group">
                <label for="Confirm Password">Confirm Password</label>
                <input type="password" name="password2" id="password2" required>
                <p class="error-message" id="password2_err" hidden></p>

            </div>
            <div class="btn-group">
                <a href="#" class="btn btn-prev">Previous</a>
                <a href="#" class="btn btn-submit" id="submit_btn" type="button">Submit</a>
            </div>
        </div>
        <!--user type   -->

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


</body>

</html>