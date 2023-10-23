<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <!-- Styles -->
    <link rel="stylesheet" href="/assets/css/base.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" type="text/css" href="/assets/css/font-awesome-5.15.1.min.css">


    <title>BASE</title>
</head>
<script
        src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha256-pasqAKBDmFT4eHoN2ndd6lN370kFiGUFyTiUHWhU7k8="
        crossorigin="anonymous"></script>
<script>
    $(function () {
        $(".toggle").on("click", function () {
            if ($(".item").hasClass("active")) {
                $(".item").removeClass("active");
            } else {
                $(".item").addClass("active");
            }
        });
    });
</script>

<body>
<nav>
    <ul class="menu">
        <li class="logo"><a href="#"><img src="/assets/img/logo2.png" alt=""></a></li>
        <li class="item"><a href="#">Home</a></li>
        <li class="item"><a href="#">About</a></li>
        <li class="item"><a href="#">Services</a></li>
        <li class="item"><a href="#">history</a></li>
        </li>
        <li class="item button"><a href="#">Log In</a></li>
        <li class="item button secondary"><a href="#">Sign Up</a></li>
        <li class="toggle"><span class="bars"></span></li>
    </ul>
</nav>
<main>
    <a href="https://youtube.com/c/FollowAndrew"
       style="position:fixed;bottom:0;color:teal;display:block;text-align:center;font-size:1em">https://youtube.com/c/FollowAndrew</a>
</main>
<div id="content" class="container">

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