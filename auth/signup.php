<?php include "../snippets/base.php" ?>


<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "../snippets/layout/head.php" ?>
    <!--  Custom Head Values  -->
    <title>Registration</title>
</head>

<body>
<?php include "../snippets/layout/header.php" ?>
<div id="content" class="container">
    <form class="form" id="regestration_form">
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
            <div class="radio-group">
                <input type="radio" id="visitor" name="user_type_id" value="2" required>
                <label for="visitor">Visitor</label>
                <input type="radio" id="kfu_member" name="user_type_id" value="1" required>
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

<?php include "../snippets/layout/footer.php" ?>


<!-- Javascript -->
<?php include "../snippets/layout/scripts.php" ?>
<script src="/assets/js/signup.js" defer></script>
<script src="../assets/js/header.js"></script>


<?php include "../snippets/layout/messages.php" ?>


</body>

</html>